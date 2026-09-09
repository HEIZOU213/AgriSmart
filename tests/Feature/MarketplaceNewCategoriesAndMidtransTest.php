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
            'jumlah' => 1,
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

    public function test_booking_durian_dp_adjusts_when_subtotal_under_100k()
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
            'jumlah' => 1,
        ]);

        $response = $this->actingAs($consumer)->post(route('checkout.store'), [
            'alamat_kirim' => 'Jl. Durian Mini No. 1',
            'selected_cart_ids' => [$cart->id],
        ]);

        $response->assertRedirect(route('konsumen.pesanan.index'));

        $order = Pesanan::where('user_id', $consumer->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertTrue($order->isBookingDurian());
        // Subtotal is 50,000 (< 100,000) so DP adjusts to 50,000
        $this->assertEquals(50000, (int)$order->dp_amount);
        $this->assertEquals(50000, (int)$order->total_harga);
        $this->assertEquals(50000, (int)$order->seller_income);
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
}

