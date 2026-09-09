<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MarketplacePortalTest extends TestCase
{
    use RefreshDatabase;

    private User $pekebun;
    private User $konsumen;
    private KategoriProduk $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pekebun = User::factory()->create([
            'name'  => 'Pak Tani Durian',
            'role'  => 'pekebun',
            'saldo' => 500000,
            'midtrans_server_key' => 'SB-Mid-server-TEST',
        ]);

        $this->konsumen = User::factory()->create([
            'name'  => 'Siti Konsumen',
            'role'  => 'user',
            'saldo' => 1000000,
        ]);

        $this->kategori = KategoriProduk::create([
            'nama_kategori' => 'Durian Segar',
            'slug'          => 'durian-segar',
        ]);
    }

    public function test_pekebun_can_access_marketplace_dashboard_with_all_statistics()
    {
        // 1. Create products for pekebun
        $p1 = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Musang King Grade A',
            'deskripsi'          => 'Durian manis legit berdaging tebal',
            'harga'              => 150000,
            'stok'               => 20,
            'foto_produk'        => null,
        ]);

        $p2 = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Black Thorn Premium',
            'deskripsi'          => 'Aroma harum tajam dan creamy',
            'harga'              => 250000,
            'stok'               => 15,
            'foto_produk'        => null,
        ]);

        // 2. Create paid order
        $orderPaid = Pesanan::create([
            'user_id'       => $this->konsumen->id,
            'kode_pesanan'  => 'INV-TEST-001',
            'total_harga'   => 300000,
            'alamat_kirim'  => 'Jl. Durian No. 12',
            'status'        => 'paid',
            'seller_income' => 282000,
            'admin_fee'     => 18000,
        ]);

        DetailPesanan::create([
            'pesanan_id'   => $orderPaid->id,
            'produk_id'    => $p1->id,
            'jumlah'       => 2,
            'harga_satuan' => 150000,
        ]);

        // 3. Create pending order
        $orderPending = Pesanan::create([
            'user_id'       => $this->konsumen->id,
            'kode_pesanan'  => 'INV-TEST-002',
            'total_harga'   => 250000,
            'alamat_kirim'  => 'Jl. Kebun No. 45',
            'status'        => 'pending',
            'seller_income' => 235000,
            'admin_fee'     => 15000,
        ]);

        DetailPesanan::create([
            'pesanan_id'   => $orderPending->id,
            'produk_id'    => $p2->id,
            'jumlah'       => 1,
            'harga_satuan' => 250000,
        ]);

        // 4. Access dashboard as pekebun
        $response = $this->actingAs($this->pekebun)
            ->get(route('portal.marketplace.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Toko dan Penjualan Panen Pekebun');
        $response->assertSee('Durian Musang King Grade A');
        $response->assertSee('INV-TEST-001');
        $response->assertSee('INV-TEST-002');
        $response->assertSee('Midtrans Gateway');

        // Assert view data contains required stats keys
        $response->assertViewHas('stats', function ($stats) {
            return isset($stats['total_produk']) && $stats['total_produk'] === 2
                && isset($stats['total_terjual']) && $stats['total_terjual'] === 2
                && isset($stats['pesanan_aktif']) && $stats['pesanan_aktif'] === 2
                && isset($stats['pesanan_masuk']) && $stats['pesanan_masuk'] === 2
                && isset($stats['pendapatan']) && $stats['pendapatan'] == 300000
                && isset($stats['saldo_dompet']) && $stats['saldo_dompet'] == 500000;
        });
    }

    public function test_pekebun_can_create_edit_update_and_delete_product()
    {
        Storage::fake('public');

        // Form create
        $this->actingAs($this->pekebun)
            ->get(route('petani.produk.create'))
            ->assertStatus(200)
            ->assertSee('Tambah Produk Panen Durian Baru');

        // Store new product
        $file = UploadedFile::fake()->create('musang_king.jpg', 100, 'image/jpeg');
        $response = $this->actingAs($this->pekebun)
            ->post(route('petani.produk.store'), [
                'nama_produk'        => 'Durian Duri Hitam',
                'kategori_produk_id' => $this->kategori->id,
                'deskripsi'          => 'Durian segar panen langsung',
                'harga'              => 200000,
                'stok'               => 10,
                'foto_produk'        => $file,
            ]);

        $response->assertRedirect(route('petani.produk.index'));
        $this->assertDatabaseHas('produk', [
            'user_id'     => $this->pekebun->id,
            'nama_produk' => 'Durian Duri Hitam',
            'harga'       => 200000,
            'stok'        => 10,
        ]);

        $produk = Produk::where('nama_produk', 'Durian Duri Hitam')->first();
        $this->assertNotNull($produk->foto_produk);
        Storage::disk('public')->assertExists($produk->foto_produk);

        // Show redirects to edit
        $this->actingAs($this->pekebun)
            ->get(route('petani.produk.show', $produk->id))
            ->assertRedirect(route('petani.produk.edit', $produk->id));

        // Edit form
        $this->actingAs($this->pekebun)
            ->get(route('petani.produk.edit', $produk->id))
            ->assertStatus(200)
            ->assertSee('Edit Produk Panen Durian');

        // Update product
        $updateResponse = $this->actingAs($this->pekebun)
            ->put(route('petani.produk.update', $produk->id), [
                'nama_produk'        => 'Durian Duri Hitam Super',
                'kategori_produk_id' => $this->kategori->id,
                'deskripsi'          => 'Durian pilihan terbaik',
                'harga'              => 220000,
                'stok'               => 8,
            ]);

        $updateResponse->assertRedirect(route('petani.produk.index'));
        $this->assertDatabaseHas('produk', [
            'id'          => $produk->id,
            'nama_produk' => 'Durian Duri Hitam Super',
            'harga'       => 220000,
            'stok'        => 8,
        ]);

        // Delete product
        $deleteResponse = $this->actingAs($this->pekebun)
            ->delete(route('petani.produk.destroy', $produk->id));

        $deleteResponse->assertRedirect(route('petani.produk.index'));
        $this->assertDatabaseMissing('produk', ['id' => $produk->id]);
    }

    public function test_product_update_validates_required_fields()
    {
        $produk = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Montong',
            'deskripsi'          => 'Manis legit',
            'harga'              => 100000,
            'stok'               => 5,
        ]);

        $response = $this->actingAs($this->pekebun)
            ->put(route('petani.produk.update', $produk->id), [
                'nama_produk'        => '',
                'kategori_produk_id' => '',
                'harga'              => '',
                'stok'               => '',
            ]);

        $response->assertSessionHasErrors(['nama_produk', 'kategori_produk_id', 'harga', 'stok']);
    }

    public function test_pekebun_can_view_orders_and_filter_by_paid_status()
    {
        $produk = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Bawor',
            'deskripsi'          => 'Bawor banyumas',
            'harga'              => 120000,
            'stok'               => 10,
        ]);

        $orderPaid = Pesanan::create([
            'user_id'       => $this->konsumen->id,
            'kode_pesanan'  => 'INV-PAID-099',
            'total_harga'   => 120000,
            'alamat_kirim'  => 'Alamat Konsumen',
            'status'        => 'paid',
            'seller_income' => 112800,
            'admin_fee'     => 7200,
        ]);

        DetailPesanan::create([
            'pesanan_id'   => $orderPaid->id,
            'produk_id'    => $produk->id,
            'jumlah'       => 1,
            'harga_satuan' => 120000,
        ]);

        $orderPending = Pesanan::create([
            'user_id'       => $this->konsumen->id,
            'kode_pesanan'  => 'INV-PEND-099',
            'total_harga'   => 120000,
            'alamat_kirim'  => 'Alamat Konsumen 2',
            'status'        => 'pending',
            'seller_income' => 112800,
            'admin_fee'     => 7200,
        ]);

        DetailPesanan::create([
            'pesanan_id'   => $orderPending->id,
            'produk_id'    => $produk->id,
            'jumlah'       => 1,
            'harga_satuan' => 120000,
        ]);

        // Filter paid
        $response = $this->actingAs($this->pekebun)
            ->get(route('petani.pesanan.index', ['filter_status' => 'paid']));

        $response->assertStatus(200);
        $response->assertSee('INV-PAID-099');
        $response->assertDontSee('INV-PEND-099');
    }

    public function test_pekebun_can_view_order_details_and_buyer_chat_link()
    {
        $produk = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Tembaga',
            'deskripsi'          => 'Warna kuning tembaga',
            'harga'              => 170000,
            'stok'               => 8,
        ]);

        $order = Pesanan::create([
            'user_id'       => $this->konsumen->id,
            'kode_pesanan'  => 'INV-DETAIL-777',
            'total_harga'   => 170000,
            'alamat_kirim'  => 'Jl. Pahlawan No. 9',
            'status'        => 'paid',
            'seller_income' => 159800,
            'admin_fee'     => 10200,
        ]);

        DetailPesanan::create([
            'pesanan_id'   => $order->id,
            'produk_id'    => $produk->id,
            'jumlah'       => 1,
            'harga_satuan' => 170000,
        ]);

        $response = $this->actingAs($this->pekebun)
            ->get(route('petani.pesanan.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee('INV-DETAIL-777');
        $response->assertSee($this->konsumen->name);
        // Assert chat link carries consumer user_id
        $response->assertSee('chat/detail/' . $this->konsumen->id);
    }


    public function test_consumer_can_browse_marketplace_add_to_cart_and_view_checkout()
    {
        $produk = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Petruk Manis',
            'deskripsi'          => 'Durian petruk khas Jepara',
            'harga'              => 140000,
            'stok'               => 10,
        ]);

        // Browse catalog
        $this->get(route('produk.index'))
            ->assertStatus(200)
            ->assertSee('Durian Petruk Manis');

        // View detail
        $this->get(route('produk.show', $produk->id))
            ->assertStatus(200)
            ->assertSee('Durian Petruk Manis');

        // Add to cart as consumer
        $cartResponse = $this->actingAs($this->konsumen)
            ->post(route('cart.store', $produk->id), [
                'jumlah' => 2,
            ]);

        $cartResponse->assertSessionHas('success');
        $this->assertDatabaseHas('keranjangs', [
            'user_id'   => $this->konsumen->id,
            'produk_id' => $produk->id,
            'jumlah'    => 2,
        ]);

        $cartItem = Keranjang::where('user_id', $this->konsumen->id)->first();

        // View cart
        $this->actingAs($this->konsumen)
            ->get(route('cart.index'))
            ->assertStatus(200)
            ->assertSee('Durian Petruk Manis');

        // View checkout
        $this->actingAs($this->konsumen)
            ->get(route('checkout.index', ['selected' => [$cartItem->id]]))
            ->assertStatus(200)
            ->assertSee('Durian Petruk Manis')
            ->assertSee('Konfirmasi');
    }

    public function test_consumer_can_cancel_pending_order_and_stock_is_restored()
    {
        $produk = Produk::create([
            'user_id'            => $this->pekebun->id,
            'kategori_produk_id' => $this->kategori->id,
            'nama_produk'        => 'Durian Pelangi',
            'deskripsi'          => 'Warna daging pelangi eksotis',
            'harga'              => 200000,
            'stok'               => 7, // Stock after ordering 3 from 10
        ]);

        $order = Pesanan::create([
            'user_id'       => $this->konsumen->id,
            'kode_pesanan'  => 'INV-CANCEL-TEST',
            'total_harga'   => 600000,
            'alamat_kirim'  => 'Jl. Merdeka No. 1',
            'status'        => 'pending',
            'seller_income' => 564000,
            'admin_fee'     => 36000,
        ]);

        DetailPesanan::create([
            'pesanan_id'   => $order->id,
            'produk_id'    => $produk->id,
            'jumlah'       => 3,
            'harga_satuan' => 200000,
        ]);

        // Cancel order as consumer via web route
        $response = $this->actingAs($this->konsumen)
            ->put(route('konsumen.pesanan.cancel', $order->id));

        $response->assertRedirect(route('konsumen.pesanan.index'));
        $response->assertSessionHas('success');

        $this->assertEquals('cancelled', $order->fresh()->status);
        // Stock should be restored (7 + 3 = 10)
        $this->assertEquals(10, $produk->fresh()->stok);
    }

    /**
     * Test: Pekebun WITHOUT Midtrans cannot access product creation page or store products.
     */
    public function test_pekebun_without_midtrans_cannot_create_product()
    {
        // Create a pekebun without midtrans_server_key
        $pekebunNoMidtrans = User::factory()->create([
            'name' => 'Pak Tani Tanpa Midtrans',
            'role' => 'pekebun',
            'midtrans_server_key' => null,
        ]);

        // Attempt to access create page — should redirect to midtrans config
        $response = $this->actingAs($pekebunNoMidtrans)->get(route('petani.produk.create'));
        $response->assertRedirect(route('petani.midtrans.index'));
        $response->assertSessionHas('error');

        // Attempt to store product — should also redirect
        $response = $this->actingAs($pekebunNoMidtrans)->post(route('petani.produk.store'), [
            'nama_produk' => 'Durian Montong',
            'kategori_produk_id' => $this->kategori->id,
            'harga' => 150000,
            'stok' => 10,
        ]);
        $response->assertRedirect(route('petani.midtrans.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test: Pekebun WITH Midtrans can successfully access product creation.
     */
    public function test_pekebun_with_midtrans_can_access_create_product()
    {
        // The $this->pekebun already has midtrans_server_key set in setUp()
        $response = $this->actingAs($this->pekebun)->get(route('petani.produk.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Produk');
    }

    /**
     * Test: DompetController index now redirects to Midtrans page.
     */
    public function test_dompet_index_redirects_to_midtrans()
    {
        $response = $this->actingAs($this->pekebun)->get(route('petani.dompet.index'));
        $response->assertRedirect(route('petani.midtrans.index'));
        $response->assertSessionHas('info');
    }
}
