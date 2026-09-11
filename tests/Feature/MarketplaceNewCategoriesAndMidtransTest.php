<?php

namespace Tests\Feature;

use App\Models\DetailPesanan;
use App\Models\KategoriProduk;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceNewCategoriesAndMidtransTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_categories_have_standard_attributes_and_defaults()
    {
        $bibitCat = KategoriProduk::where('slug', 'bibit-durian')->first();
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();
        $turunanCat = KategoriProduk::where('slug', 'produk-turunan-durian')->first();

        $this->assertNotNull($bibitCat);
        $this->assertNotNull($buahCat);
        $this->assertNotNull($turunanCat);

        $this->assertEquals('langsung', $bibitCat->tipe_penjualan);
        $this->assertEquals('bibit', $bibitCat->satuan_default);

        $this->assertEquals('booking_dp', $buahCat->tipe_penjualan);
        $this->assertEquals('kg', $buahCat->satuan_default);
        $this->assertEquals(100000, (int)$buahCat->dp_amount);

        $this->assertEquals('langsung', $turunanCat->tipe_penjualan);
        $this->assertEquals('pcs', $turunanCat->satuan_default);
    }

    public function test_pekebun_can_configure_own_midtrans_credentials()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'saldo' => 0,
        ]);

        $response = $this->actingAs($pekebun)->get(route('petani.midtrans.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Akun Midtrans');

        $updateResponse = $this->actingAs($pekebun)->post(route('petani.midtrans.update'), [
            'midtrans_server_key' => 'SB-Mid-server-TEST12345',
            'midtrans_client_key' => 'SB-Mid-client-TEST12345',
            'midtrans_merchant_id' => 'G12345678',
            'midtrans_is_production' => '1',
        ]);

        $updateResponse->assertRedirect(route('petani.midtrans.index'));
        $pekebun->refresh();

        $this->assertEquals('SB-Mid-server-TEST12345', $pekebun->midtrans_server_key);
        $this->assertEquals('SB-Mid-client-TEST12345', $pekebun->midtrans_client_key);
        $this->assertEquals('G12345678', $pekebun->midtrans_merchant_id);
        $this->assertTrue($pekebun->midtrans_is_production);
        $this->assertTrue($pekebun->hasCustomMidtrans());
    }

    public function test_direct_sale_for_bibit_and_turunan_has_zero_admin_fee()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'SB-Mid-server-SELLER1',
        ]);

        $consumer = User::factory()->create(['role' => 'user']);

        $bibitCat = KategoriProduk::where('slug', 'bibit-durian')->first();
        $produkBibit = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $bibitCat->id,
            'nama_produk' => 'Bibit Durian Musang King Super',
            'deskripsi' => 'Bibit unggul okulasi',
            'harga' => 75000,
            'stok' => 20,
            'satuan' => 'bibit',
        ]);

        $cart = Keranjang::create([
            'user_id' => $consumer->id,
            'produk_id' => $produkBibit->id,
            'jumlah' => 2,
        ]);

        $response = $this->actingAs($consumer)->post(route('checkout.store'), [
            'alamat_kirim' => 'Jl. Durian Raya No. 10',
            'selected_cart_ids' => [$cart->id],
        ]);

        $response->assertRedirect(route('konsumen.pesanan.index'));

        $order = Pesanan::where('user_id', $consumer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('langsung', $order->tipe_pesanan);
        $this->assertEquals(150000, (int)$order->total_harga);
        $this->assertEquals(0, (int)$order->admin_fee); // ZERO ADMIN FEE!
        $this->assertEquals(150000, (int)$order->seller_income);
        $this->assertEquals('pending', $order->status);
    }

    public function test_buah_durian_booking_charges_fixed_dp_and_generates_booking_order()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'SB-Mid-server-SELLER1',
        ]);

        $consumer = User::factory()->create(['role' => 'user']);

        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();
        $produkBuah = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Duri Hitam Segar',
            'deskripsi' => 'Durian pohon tua istimewa',
            'harga' => 150000, // per kg
            'stok' => 10,
            'satuan' => 'kg',
        ]);

        $cart = Keranjang::create([
            'user_id' => $consumer->id,
            'produk_id' => $produkBuah->id,
            'jumlah' => 2,
        ]);

        $response = $this->actingAs($consumer)->post(route('checkout.store'), [
            'alamat_kirim' => 'Jl. Kebun Durian No. 5',
            'selected_cart_ids' => [$cart->id],
        ]);

        $response->assertRedirect(route('konsumen.pesanan.index'));

        $order = Pesanan::where('user_id', $consumer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertTrue($order->isBookingDurian());
        $this->assertStringStartsWith('BKG-', $order->kode_pesanan);
        $this->assertEquals(100000, (int)$order->total_harga); // DP charged at checkout
        $this->assertEquals(100000, (int)$order->dp_amount);
        $this->assertEquals(0, (int)$order->admin_fee);
        $this->assertEquals('pending', $order->status);
    }

    public function test_midtrans_callback_processes_booking_dp_and_increments_pekebun_balance()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'saldo' => 0,
            'midtrans_server_key' => 'TEST-SERVER-KEY',
        ]);

        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Bawor Banyumas',
            'harga' => 120000,
            'stok' => 10,
            'satuan' => 'kg',
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-TEST01',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 100000,
            'dp_amount' => 100000,
            'admin_fee' => 0,
            'seller_income' => 100000,
            'status' => 'pending',
            'alamat_kirim' => 'Alamat Pengiriman',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 120000,
        ]);

        $serverKey = 'TEST-SERVER-KEY';
        $statusCode = '200';
        $grossAmount = '100000.00';
        $signature = hash('sha512', $order->kode_pesanan . $statusCode . $grossAmount . $serverKey);

        $response = $this->postJson('/api/midtrans-callback', [
            'order_id' => $order->kode_pesanan,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'transaction_status' => 'settlement',
            'signature_key' => $signature,
        ]);

        $response->assertStatus(200);

        $order->refresh();
        $pekebun->refresh();

        $this->assertEquals('booked', $order->status);
        $this->assertNotNull($order->dp_paid_at);
        $this->assertEquals(100000, (int)$pekebun->saldo);
    }

    public function test_pekebun_can_input_timbangan_and_system_calculates_sisa_pelunasan_and_kwitansi()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'TEST-KEY',
        ]);

        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Super',
            'harga' => 100000, // Rp 100.000 / kg
            'stok' => 5,
            'satuan' => 'kg',
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-TIMBANG',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 100000,
            'dp_amount' => 100000,
            'status' => 'booked',
            'alamat_kirim' => 'Alamat Kirim',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 100000,
        ]);

        // Pekebun inputs harvest weight: 3.5 kg -> Total = 3.5 * 100.000 = 350.000. Sisa = 350.000 - 100.000 = 250.000
        $response = $this->actingAs($pekebun)->post(route('petani.pesanan.timbangan', $order->id), [
            'berat_aktual_kg' => 3.5,
        ]);

        $response->assertRedirect(route('petani.pesanan.show', $order->id));

        $order->refresh();
        $this->assertEquals(3.5, (float)$order->berat_aktual_kg);
        $this->assertEquals(350000, (int)$order->total_setelah_timbang);
        $this->assertEquals(250000, (int)$order->sisa_pelunasan);
        $this->assertEquals('menunggu_pelunasan', $order->status);
        $this->assertNotNull($order->kwitansi_nomor);
        $this->assertNotNull($order->kwitansi_qr_payload);
        $this->assertNotNull($order->pelunasan_snap_token);
    }

    public function test_kwitansi_view_accessible_by_owner_and_pekebun_and_blocks_unauthorized()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);

        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();
        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Montong',
            'harga' => 120000,
            'stok' => 5,
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-KWITANSI',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 360000,
            'dp_amount' => 100000,
            'berat_aktual_kg' => 3.0,
            'harga_per_kg' => 120000,
            'total_setelah_timbang' => 360000,
            'sisa_pelunasan' => 260000,
            'kwitansi_nomor' => 'KW-20260909-00001',
            'status' => 'menunggu_pelunasan',
            'alamat_kirim' => 'Alamat Kirim',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 120000,
        ]);

        // Consumer can access kwitansi
        $resConsumer = $this->actingAs($consumer)->get(route('konsumen.pesanan.kwitansi', $order->id));
        $resConsumer->assertStatus(200);
        $resConsumer->assertSee('KW-20260909-00001');
        $resConsumer->assertSee('E-Kwitansi Pemesanan & Pelunasan Buah Durian', false);

        // Pekebun who sells the durian can also access kwitansi
        $resPekebun = $this->actingAs($pekebun)->get(route('konsumen.pesanan.kwitansi', $order->id));
        $resPekebun->assertStatus(200);

        // Unauthorized other consumer gets 403
        $resOther = $this->actingAs($otherUser)->get(route('konsumen.pesanan.kwitansi', $order->id));
        $resOther->assertStatus(403);
    }

    public function test_midtrans_callback_for_pelunasan_marks_order_paid()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'saldo' => 100000, // had DP
            'midtrans_server_key' => 'TEST-KEY',
        ]);

        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Musang King',
            'harga' => 200000,
            'stok' => 5,
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-PELUNASAN',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 400000,
            'dp_amount' => 100000,
            'berat_aktual_kg' => 2.0,
            'harga_per_kg' => 200000,
            'total_setelah_timbang' => 400000,
            'sisa_pelunasan' => 300000,
            'status' => 'menunggu_pelunasan',
            'alamat_kirim' => 'Alamat Pengiriman',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 200000,
        ]);

        $serverKey = 'TEST-KEY';
        $orderIdCallback = 'PELUNASAN-' . $order->kode_pesanan;
        $statusCode = '200';
        $grossAmount = '300000.00';
        $signature = hash('sha512', $orderIdCallback . $statusCode . $grossAmount . $serverKey);

        $response = $this->postJson('/api/midtrans-callback', [
            'order_id' => $orderIdCallback,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'transaction_status' => 'settlement',
            'signature_key' => $signature,
        ]);

        $response->assertStatus(200);

        $order->refresh();
        $pekebun->refresh();

        $this->assertEquals('paid', $order->status);
        $this->assertNotNull($order->pelunasan_paid_at);
        $this->assertEquals(400000, (int)$pekebun->saldo); // 100k DP + 300k pelunasan
    }

    public function test_pekebun_qr_scanner_verifies_valid_order_and_blocks_other_pekebun()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $otherPekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);

        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();
        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Petruk',
            'harga' => 100000,
            'stok' => 5,
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-SCAN01',
            'kwitansi_nomor' => 'KW-20260909-SCAN01',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 100000,
            'dp_amount' => 100000,
            'status' => 'booked',
            'alamat_kirim' => 'Alamat Kirim',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 100000,
        ]);

        // Pekebun can access scan page
        $resPage = $this->actingAs($pekebun)->get(route('petani.scan.index'));
        $resPage->assertStatus(200);

        // Pekebun verifies order via code JSON
        $resScan = $this->actingAs($pekebun)->postJson(route('petani.scan.verify'), [
            'code' => $order->kode_pesanan,
        ]);

        $resScan->assertStatus(200);
        $resScan->assertJson([
            'success' => true,
            'data' => [
                'kode_pesanan' => 'BKG-20260909-SCAN01',
                'is_booking' => true,
            ]
        ]);

        // Another pekebun scanning this order gets 403 (IDOR prevention)
        $resOtherScan = $this->actingAs($otherPekebun)->postJson(route('petani.scan.verify'), [
            'code' => $order->kode_pesanan,
        ]);

        $resOtherScan->assertStatus(403);
    }

    public function test_booking_durian_dp_remains_fixed_100k_with_minimum_purchase()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        // Product priced at 50k per kg
        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Mini Lokal',
            'harga' => 50000,
            'stok' => 10,
            'satuan' => 'kg',
        ]);

        $cart = Keranjang::create([
            'user_id' => $consumer->id,
            'produk_id' => $produk->id,
            'jumlah' => 2,
        ]);

        $response = $this->actingAs($consumer)->post(route('checkout.store'), [
            'alamat_kirim' => 'Jl. Durian Mini No. 1',
            'selected_cart_ids' => [$cart->id],
        ]);

        $response->assertRedirect(route('konsumen.pesanan.index'));

        $order = Pesanan::where('user_id', $consumer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertTrue($order->isBookingDurian());
        // DP remains fixed at 100,000
        $this->assertEquals(100000, (int)$order->dp_amount);
        $this->assertEquals(100000, (int)$order->total_harga);
        $this->assertEquals(100000, (int)$order->seller_income);
    }

    public function test_booking_durian_timbangan_with_adjusted_dp_and_zero_remaining_balance_marks_as_paid()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Mini Lokal',
            'harga' => 50000,
            'stok' => 10,
            'satuan' => 'kg',
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-MINI01',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 50000,
            'dp_amount' => 50000,
            'status' => 'booked',
            'alamat_kirim' => 'Jl. Durian Mini No. 1',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 50000,
        ]);

        // Pekebun weighs the fruit: 0.9 kg -> Total = 0.9 * 50,000 = 45,000. DP was 50,000.
        // Sisa pelunasan = max(0, 45000 - 50000) = 0.
        // Status should automatically become 'paid'!
        $response = $this->actingAs($pekebun)->post(route('petani.pesanan.timbangan', $order->id), [
            'berat_aktual_kg' => 0.9,
        ]);

        $response->assertRedirect(route('petani.pesanan.show', $order->id));

        $order->refresh();
        $this->assertEquals(0.9, (float)$order->berat_aktual_kg);
        $this->assertEquals(45000, (int)$order->total_setelah_timbang);
        $this->assertEquals(0, (int)$order->sisa_pelunasan);
        $this->assertEquals('paid', $order->status);
        $this->assertTrue($order->isLunas());
        $this->assertNull($order->pelunasan_snap_token);
    }

    public function test_booking_durian_timbangan_with_adjusted_dp_and_positive_remaining_balance()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Mini Lokal',
            'harga' => 50000,
            'stok' => 10,
            'satuan' => 'kg',
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-20260909-MINI02',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 50000,
            'dp_amount' => 50000,
            'status' => 'booked',
            'alamat_kirim' => 'Jl. Durian Mini No. 2',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 50000,
        ]);

        // Pekebun weighs the fruit: 1.4 kg -> Total = 1.4 * 50,000 = 70,000. DP was 50,000.
        // Sisa pelunasan = 70,000 - 50,000 = 20,000.
        // Status should become 'menunggu_pelunasan'
        $response = $this->actingAs($pekebun)->post(route('petani.pesanan.timbangan', $order->id), [
            'berat_aktual_kg' => 1.4,
        ]);

        $response->assertRedirect(route('petani.pesanan.show', $order->id));

        $order->refresh();
        $this->assertEquals(1.4, (float)$order->berat_aktual_kg);
        $this->assertEquals(70000, (int)$order->total_setelah_timbang);
        $this->assertEquals(20000, (int)$order->sisa_pelunasan);
        $this->assertEquals('menunggu_pelunasan', $order->status);
        $this->assertNotNull($order->pelunasan_snap_token);
    }

    /**
     * Test: API verify QR returns valid financial details and handles settlement.
     */
    public function test_api_verify_qr_and_settle_order()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'SB-Mid-server-test',
        ]);
        $konsumen = User::factory()->create(['role' => 'user']);

        $order = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'BKG-20260909-SCAN01',
            'kwitansi_nomor' => 'KWT-20260909-SCAN01',
            'tipe_pesanan' => 'booking_durian',
            'dp_amount' => 50000,
            'total_harga' => 50000,
            'total_setelah_timbang' => 80000,
            'sisa_pelunasan' => 30000,
            'status' => 'menunggu_pelunasan',
            'alamat_kirim' => 'Jl. Bengkalis No. 1',
        ]);

        // Pekebun calls apiVerifyQr
        $response = $this->actingAs($pekebun)->postJson('/api/petani/pesanan/verify-qr', [
            'qr_token' => 'BKG-20260909-SCAN01',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'needs_settlement' => true,
            'remaining_balance' => 30000,
        ]);

        // Settle order via API
        $settleResponse = $this->actingAs($pekebun)->postJson("/api/petani/pesanan/{$order->id}/settle");
        $settleResponse->assertStatus(200);
        $settleResponse->assertJson(['success' => true]);

        $order->refresh();
        $this->assertEquals('selesai', $order->status);
        $this->assertEquals(0, $order->sisa_pelunasan);
    }

    /**
     * Test: API verify payment for mobile endpoint.
     */
    public function test_api_verify_payment()
    {
        $konsumen = User::factory()->create(['role' => 'user']);

        $order = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'INV-20260909-VPAY01',
            'tipe_pesanan' => 'langsung',
            'total_harga' => 150000,
            'status' => 'pending',
            'alamat_kirim' => 'Jl. Riau No. 10',
        ]);

        $response = $this->actingAs($konsumen)->postJson("/api/orders/{$order->id}/verify-payment");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $order->refresh();
        $this->assertEquals('paid', $order->status);
    }

    /**
     * Test: Pekebun can fix/update Midtrans credentials and it auto-heals fallback snap tokens on pending orders.
     */
    public function test_pekebun_can_update_midtrans_credentials_and_auto_heal_pending_orders()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'SB-Mid-server-OLD-WRONG',
            'midtrans_client_key' => 'SB-Mid-client-OLD-WRONG',
        ]);
        $konsumen = User::factory()->create(['role' => 'user']);

        $kategori = KategoriProduk::where('slug', 'buah-durian')->first();
        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Durian Tembaga',
            'harga' => 80000,
            'stok' => 10,
        ]);

        // Order stuck with fallback snap token
        $order = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'BKG-20260909-HEAL01',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 80000,
            'dp_amount' => 80000,
            'snap_token' => 'FALLBACK-SNAP-abcdef123456',
            'status' => 'pending',
            'alamat_kirim' => 'Jl. Bengkalis No. 5',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 80000,
        ]);

        // Pekebun fixes/updates their Midtrans credentials
        $response = $this->actingAs($pekebun)->post(route('petani.midtrans.update'), [
            'midtrans_server_key' => 'SB-Mid-server-CORRECT-TEST',
            'midtrans_client_key' => 'SB-Mid-client-CORRECT-TEST',
            'midtrans_merchant_id' => 'G999888777',
        ]);

        $response->assertRedirect(route('petani.midtrans.index'));
        $response->assertSessionHas('success');

        $pekebun->refresh();
        $this->assertEquals('SB-Mid-server-CORRECT-TEST', $pekebun->midtrans_server_key);
        $this->assertEquals('SB-Mid-client-CORRECT-TEST', $pekebun->midtrans_client_key);
        // Auto-detected sandbox
        $this->assertFalse($pekebun->isMidtransProduction());

        // The order's snap token should be auto-healed (no longer FALLBACK-SNAP)
        $order->refresh();
        $this->assertNotNull($order->snap_token);
        $this->assertStringNotContainsString('FALLBACK-SNAP', $order->snap_token);
    }

    /**
     * Test: Consumer can call refreshSnapToken to regenerate valid snap token.
     */
    public function test_consumer_can_refresh_snap_token()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'SB-Mid-server-TESTKEY',
        ]);
        $konsumen = User::factory()->create(['role' => 'user']);

        $kategori = KategoriProduk::where('slug', 'buah-durian')->first();
        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Durian Duri Hitam',
            'harga' => 150000,
            'stok' => 5,
        ]);

        $order = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'BKG-20260909-REFRESH01',
            'tipe_pesanan' => 'booking_durian',
            'total_harga' => 150000,
            'dp_amount' => 100000,
            'snap_token' => 'FALLBACK-SNAP-oldtoken123',
            'status' => 'pending',
            'alamat_kirim' => 'Jl. Merdeka No. 9',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 150000,
        ]);

        $response = $this->actingAs($konsumen)->postJson(route('konsumen.pesanan.refresh-snap-token', $order->id));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $order->refresh();
        $this->assertStringNotContainsString('FALLBACK-SNAP', $order->snap_token);
    }

    /**
     * Test: Durian booking requires minimum 2 kg purchase and charges fixed Rp 100.000 DP.
     */
    public function test_buah_durian_booking_enforces_minimum_two_kg_purchase()
    {
        $pekebun = User::factory()->create([
            'role' => 'pekebun',
            'midtrans_server_key' => 'TEST-SERVER-KEY-123',
        ]);
        $consumer = User::factory()->create(['role' => 'user']);

        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();
        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Montong Super',
            'harga' => 85000,
            'stok' => 20,
            'satuan' => 'kg',
        ]);

        // 1. Attempt checkout with 1 kg via web store -> should be rejected
        $cart1 = Keranjang::create([
            'user_id' => $consumer->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
        ]);

        $failResponse = $this->actingAs($consumer)->post(route('checkout.store'), [
            'alamat_kirim' => 'Jl. Durian No. 1',
            'selected_cart_ids' => [$cart1->id],
        ]);
        $failResponse->assertRedirect(route('cart.index'));
        $failResponse->assertSessionHas('error');

        // 2. Attempt checkout with 1 kg via API -> should return 400
        $apiFailResponse = $this->actingAs($consumer)->postJson('/api/checkout', [
            'alamat_pengiriman' => 'Jl. Durian No. 1',
            'payment_method' => 'midtrans',
            'cart_ids' => [$cart1->id],
        ]);
        $apiFailResponse->assertStatus(400);
        $apiFailResponse->assertJsonFragment(['success' => false]);

        // 3. Checkout with 2 kg -> should succeed with fixed DP Rp 100.000
        $cart1->update(['jumlah' => 2]);

        $successResponse = $this->actingAs($consumer)->post(route('checkout.store'), [
            'alamat_kirim' => 'Jl. Durian No. 1',
            'selected_cart_ids' => [$cart1->id],
        ]);
        $successResponse->assertRedirect(route('konsumen.pesanan.index'));

        $order = Pesanan::where('user_id', $consumer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertTrue($order->isBookingDurian());
        $this->assertEquals(100000, (int)$order->dp_amount);
        $this->assertEquals(100000, (int)$order->total_harga);
    }

    /**
     * Test: Midtrans environment is determined purely by the checkbox, not by key prefix.
     */
    public function test_midtrans_environment_checkbox_without_prefix_dependency()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        // 1. Key has NO prefix, but checkbox is unchecked (false) -> Sandbox
        $this->actingAs($pekebun)->post(route('petani.midtrans.update'), [
            'midtrans_server_key' => 'CUSTOM-KEY-WITHOUT-PREFIX-1',
            'midtrans_client_key' => 'CUSTOM-CLIENT-KEY-1',
            'midtrans_is_production' => '0',
        ]);
        $pekebun->refresh();
        $this->assertFalse($pekebun->isMidtransProduction());

        // 2. Key starts with 'SB-', but checkbox IS checked (true) -> Production
        $this->actingAs($pekebun)->post(route('petani.midtrans.update'), [
            'midtrans_server_key' => 'SB-Mid-server-CUSTOM',
            'midtrans_client_key' => 'SB-Mid-client-CUSTOM',
            'midtrans_is_production' => '1',
        ]);
        $pekebun->refresh();
        $this->assertTrue($pekebun->isMidtransProduction());
    }

    /**
     * Test: Marketplace views display subtle booking explanation and enforce minimum 2 purchase.
     */
    public function test_marketplace_views_render_subtle_keterangan_and_enforce_min_two_purchase()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Bawor Super',
            'harga' => 90000,
            'stok' => 15,
            'satuan' => 'kg',
            'tipe_produk' => 'booking_panen',
            'estimasi_panen' => '25 September 2026',
        ]);

        // 1. Check catalog view renders subtle indicator
        $catalogResponse = $this->get(route('produk.index'));
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('Booking Panen');
        $catalogResponse->assertSee('Min. 2 kg');

        // 2. Check detail view renders subtle terms and min=2 input
        $detailResponse = $this->get(route('produk.show', $produk->id));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Ketentuan Pemesanan Buah Durian');
        $detailResponse->assertSee('Minimal Pembelian:');
        $detailResponse->assertSee('value="2"', false);
        $detailResponse->assertSee('min="2"', false);
        $detailResponse->assertSee('25 September 2026');

        // 3. Consumer submitting quantity < 2 is rejected
        $rejectResponse = $this->actingAs($consumer)
            ->post(route('cart.store', $produk->id), [
                'jumlah' => 1,
            ]);
        $rejectResponse->assertSessionHas('error');

        // 4. Consumer submitting quantity 2 succeeds
        $successResponse = $this->actingAs($consumer)
            ->post(route('cart.store', $produk->id), [
                'jumlah' => 2,
            ]);
        $successResponse->assertSessionHas('success');
    }

    /**
     * Test: Model Pesanan otomatis menghasilkan nomor kwitansi dan QR payload pada event lifecycle.
     */
    public function test_pesanan_model_lifecycle_automatically_generates_kwitansi_nomor_and_qr_payload()
    {
        $consumer = User::factory()->create(['role' => 'user']);
        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'INV-TEST-KW-' . rand(1000, 9999),
            'total_harga' => 100000,
            'status' => 'paid',
            'alamat_kirim' => 'Jl. Uji Kwitansi No. 1',
        ]);

        $this->assertNotEmpty($order->kwitansi_nomor);
        $this->assertStringStartsWith('KW-', $order->kwitansi_nomor);
        $this->assertNotEmpty($order->kwitansi_qr_payload);
        $this->assertStringContainsString((string)$order->id, $order->kwitansi_qr_payload);
        $this->assertNotEmpty($order->qr_code_url);
    }

    /**
     * Test: Halaman E-Kwitansi dapat diakses oleh Konsumen pemilik dan Pekebun penjual.
     */
    public function test_ekwitansi_page_accessible_by_konsumen_and_pekebun()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $stranger = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian Musang King Kwitansi',
            'harga' => 120000,
            'stok' => 10,
            'satuan' => 'kg',
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-TEST-KW-' . rand(1000, 9999),
            'tipe_pesanan' => 'booking_durian',
            'dp_amount' => 100000,
            'total_harga' => 100000,
            'status' => 'booked',
            'alamat_kirim' => 'Jl. Durian Wangi No. 8',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 2,
            'harga_satuan' => 120000,
        ]);

        // 1. Konsumen pemilik berhasil membuka E-Kwitansi
        $consumerRes = $this->actingAs($consumer)->get(route('konsumen.pesanan.kwitansi', $order->id));
        $consumerRes->assertStatus(200);
        $consumerRes->assertSee('E-Kwitansi');
        $consumerRes->assertSee($order->kode_pesanan);

        // 2. Pekebun penjual berhasil membuka E-Kwitansi
        $pekebunRes = $this->actingAs($pekebun)->get(route('konsumen.pesanan.kwitansi', $order->id));
        $pekebunRes->assertStatus(200);
        $pekebunRes->assertSee('E-Kwitansi');

        // 3. User lain ditolak 403
        $strangerRes = $this->actingAs($stranger)->get(route('konsumen.pesanan.kwitansi', $order->id));
        $strangerRes->assertStatus(403);
    }

    /**
     * Test: API Mobile (/api/orders dan /api/petani/pesanan/verify-qr) kompatibel penuh tanpa regresi.
     */
    public function test_mobile_api_endpoints_retain_full_compatibility()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $consumer = User::factory()->create(['role' => 'user']);
        $buahCat = KategoriProduk::where('slug', 'buah-durian')->first();

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $buahCat->id,
            'nama_produk' => 'Durian API Test',
            'harga' => 100000,
            'stok' => 20,
            'satuan' => 'kg',
        ]);

        $order = Pesanan::create([
            'user_id' => $consumer->id,
            'kode_pesanan' => 'BKG-API-' . rand(1000, 9999),
            'tipe_pesanan' => 'booking_durian',
            'dp_amount' => 100000,
            'total_harga' => 100000,
            'status' => 'booked',
            'alamat_kirim' => 'Jl. Mobile Flutter No. 10',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $order->id,
            'produk_id' => $produk->id,
            'jumlah' => 2,
            'harga_satuan' => 100000,
        ]);

        // 1. Mobile GET /api/orders
        $ordersResponse = $this->actingAs($consumer, 'sanctum')->getJson('/api/orders');
        $ordersResponse->assertStatus(200);
        $ordersResponse->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'kode_pesanan', 'total_harga', 'status', 'detail_pesanan']
            ]
        ]);

        // 2. Mobile Scanner POST /api/petani/pesanan/verify-qr
        $verifyResponse = $this->actingAs($pekebun, 'sanctum')->postJson('/api/petani/pesanan/verify-qr', [
            'qr_token' => $order->kode_pesanan,
        ]);
        $verifyResponse->assertStatus(200);
        $verifyResponse->assertJsonStructure([
            'success',
            'needs_settlement',
            'remaining_balance',
            'total',
            'dp_amount',
            'type',
            'order' => [
                'id',
                'kode_pesanan',
                'kwitansi_nomor',
                'total',
                'dp_amount',
                'status',
            ]
        ]);

        // 3. Mobile Scanner Alias POST /api/petani/pesanan/scan/verify
        $aliasVerify = $this->actingAs($pekebun, 'sanctum')->postJson('/api/petani/pesanan/scan/verify', [
            'qr_token' => $order->kwitansi_qr_payload,
        ]);
        $aliasVerify->assertStatus(200);
        $this->assertTrue($aliasVerify->json('success'));
    }
}


