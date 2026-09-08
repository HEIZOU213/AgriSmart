<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\MarketChat;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\KategoriProduk;
use App\Models\KategoriEdukasi;
use App\Models\KontenEdukasi;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SystemAuditFixesTest extends TestCase
{
    use RefreshDatabase;

    public function test_realtime_chat_notification_counts_market_chat_unread_messages()
    {
        $sender = User::factory()->create(['role' => 'user']);
        $receiver = User::factory()->create(['role' => 'pekebun']);

        MarketChat::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Halo apakah durian musang king masih ada?',
            'is_read' => false,
        ]);

        $response = $this->actingAs($receiver)->getJson('/api/cek-notifikasi');

        $response->assertOk();
        $response->assertJson([
            'chat' => 1,
        ]);
    }

    public function test_admin_is_prohibited_from_logging_in_via_public_login_form()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@agrismart.test',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login-otp', [
            'email' => $admin->email,
            'password' => 'secret123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_homepage_hero_statistics_accurately_counts_paid_and_shipped_orders()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'INV-TEST-001',
            'total_harga' => 100000,
            'status' => 'paid',
            'alamat_kirim' => 'Jl. Durian No. 1',
        ]);

        Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'INV-TEST-002',
            'total_harga' => 150000,
            'status' => 'shipping',
            'alamat_kirim' => 'Jl. Durian No. 2',
        ]);

        Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'INV-TEST-003',
            'total_harga' => 200000,
            'status' => 'done',
            'alamat_kirim' => 'Jl. Durian No. 3',
        ]);

        Pesanan::create([
            'user_id' => $user->id,
            'kode_pesanan' => 'INV-TEST-004',
            'total_harga' => 50000,
            'status' => 'pending', // should not be counted
            'alamat_kirim' => 'Jl. Durian No. 4',
        ]);

        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('homepage_hero_stats');

        $response = $this->get(route('homepage'));
        $response->assertOk();
        $response->assertViewHas('heroStats', function ($stats) {
            return isset($stats['pesanan_selesai']) && $stats['pesanan_selesai'] === 3;
        });
    }

    public function test_konten_edukasi_generates_unique_slug_when_duplicate_titles_occur()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kategori = KategoriEdukasi::create([
            'nama_kategori' => 'Teknik Tanam',
            'slug' => 'teknik-tanam',
        ]);

        $response1 = $this->actingAs($admin)->post(route('admin.konten-edukasi.store'), [
            'judul' => 'Cara Menanam Durian Unggul',
            'kategori_edukasi_id' => $kategori->id,
            'isi_konten' => 'Isi artikel pertama tentang durian unggul.',
            'tipe_konten' => 'artikel',
        ]);
        $response1->assertSessionHas('success');

        // Second article with the EXACT same title
        $response2 = $this->actingAs($admin)->post(route('admin.konten-edukasi.store'), [
            'judul' => 'Cara Menanam Durian Unggul',
            'kategori_edukasi_id' => $kategori->id,
            'isi_konten' => 'Isi artikel kedua tentang durian unggul.',
            'tipe_konten' => 'artikel',
        ]);
        $response2->assertSessionHas('success');

        $this->assertDatabaseHas('konten_edukasi', ['slug' => 'cara-menanam-durian-unggul']);
        $this->assertDatabaseHas('konten_edukasi', ['slug' => 'cara-menanam-durian-unggul-1']);
    }

    public function test_web_petani_iot_redirects_to_layanan_index()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        $response = $this->actingAs($pekebun)->get('/petani/iot');

        $response->assertRedirect(route('layanan.index'));
    }

    public function test_consumer_can_cancel_order_via_post_or_put_and_stock_is_restored()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $konsumen = User::factory()->create(['role' => 'user']);
        $kategori = KategoriProduk::create([
            'nama_kategori' => 'Buah Segar',
            'slug' => 'buah-segar',
        ]);

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Durian Duri Hitam',
            'harga' => 200000,
            'stok' => 5,
            'deskripsi' => 'Manis legit',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'INV-CANCEL-001',
            'total_harga' => 400000,
            'status' => 'pending',
            'alamat_kirim' => 'Jl. Merdeka 10',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'jumlah' => 2,
            'harga_satuan' => 200000,
        ]);

        // Cancel via POST to route pesanan.cancel
        $response = $this->actingAs($konsumen)->post(route('pesanan.cancel', $pesanan->id));

        $response->assertSessionHas('success');
        $this->assertEquals('cancelled', $pesanan->fresh()->status);
        $this->assertEquals(7, $produk->fresh()->stok); // 5 + 2 restored
    }

    public function test_consumer_can_confirm_order_received_and_status_becomes_done_and_notifies_seller()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $konsumen = User::factory()->create(['role' => 'user']);
        $kategori = KategoriProduk::create([
            'nama_kategori' => 'Durian Utuh',
            'slug' => 'durian-utuh',
        ]);

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Durian Musang King',
            'harga' => 150000,
            'stok' => 10,
            'deskripsi' => 'Super manis',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'INV-TEST-SHIPPING-01',
            'total_harga' => 150000,
            'seller_income' => 141000,
            'admin_fee' => 9000,
            'status' => 'shipping',
            'alamat_kirim' => 'Jl. Mawar No. 1',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 150000,
        ]);

        $response = $this->actingAs($konsumen)->patch(route('pesanan.selesai', $pesanan->id));
        $response->assertSessionHas('success');
        $this->assertEquals('done', $pesanan->fresh()->status);

        // Assert seller received notification
        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $pekebun->id,
            'type' => 'success',
        ]);
    }

    public function test_pekebun_cancelling_shipping_order_refunds_consumer_and_deducts_seller_income()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun', 'saldo' => 200000]);
        $konsumen = User::factory()->create(['role' => 'user', 'saldo' => 50000]);
        $kategori = KategoriProduk::create([
            'nama_kategori' => 'Olahan',
            'slug' => 'olahan',
        ]);

        $produk = Produk::create([
            'user_id' => $pekebun->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Pancake Durian',
            'harga' => 100000,
            'stok' => 4,
            'deskripsi' => 'Pancake lezat',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $konsumen->id,
            'kode_pesanan' => 'INV-SHIP-CANCEL-01',
            'total_harga' => 100000,
            'seller_income' => 94000,
            'admin_fee' => 6000,
            'status' => 'shipping',
            'alamat_kirim' => 'Jl. Melati No. 5',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'jumlah' => 1,
            'harga_satuan' => 100000,
        ]);

        // Petani cancels the shipping order
        $response = $this->actingAs($pekebun)->put(route('petani.pesanan.update', $pesanan->id), [
            'status' => 'cancelled',
        ]);

        $response->assertRedirect(route('petani.pesanan.show', $pesanan->id));
        $this->assertEquals('cancelled', $pesanan->fresh()->status);
        // Restocked
        $this->assertEquals(5, $produk->fresh()->stok);
        // Seller income deducted
        $this->assertEquals(200000 - 94000, $pekebun->fresh()->saldo);
        // Buyer refunded
        $this->assertEquals(50000 + 100000, $konsumen->fresh()->saldo);
    }

    public function test_admin_can_fetch_iot_data_for_any_device()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        $device = \App\Models\Device::create([
            'user_id' => $pekebun->id,
            'name' => 'Alat Durian Kebun A',
            'serial_number' => 'ESP32-DUR-001',
            'pin_code' => '123456',
            'mode' => 'AUTO',
            'is_pump_on' => false,
        ]);

        \App\Models\SensorData::create([
            'device_id' => $device->id,
            'moisture' => 65.5,
            'temperature' => 28.0,
            'humidity' => 80.0,
        ]);

        $response = $this->actingAs($admin)->getJson('/iot/data/' . $device->serial_number);
        $response->assertOk();
        $response->assertJson([
            'moisture' => 65.5,
            'temperature' => 28.0,
            'humidity' => 80.0,
            'pump_status' => 'MATI',
        ]);
    }

    public function test_admin_approving_withdrawal_creates_notification_for_pekebun()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pekebun = User::factory()->create(['role' => 'pekebun', 'saldo' => 500000]);

        $withdraw = \App\Models\Withdrawal::create([
            'user_id' => $pekebun->id,
            'jumlah' => 100000,
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.withdraw.approve', $withdraw->id));
        $response->assertSessionHas('success');
        $this->assertEquals('approved', $withdraw->fresh()->status);

        $this->assertDatabaseHas('notifikasis', [
            'user_id' => $pekebun->id,
            'type' => 'success',
        ]);
    }

    public function test_public_edukasi_show_renders_with_real_footer_and_related_articles()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kategori = KategoriEdukasi::create([
            'nama_kategori' => 'Teknologi Modern',
            'slug' => 'teknologi-modern',
        ]);

        $edukasi1 = KontenEdukasi::create([
            'user_id' => $admin->id,
            'kategori_edukasi_id' => $kategori->id,
            'judul' => 'Teknologi Sensor IoT Durian Unggul',
            'slug' => 'teknologi-sensor-iot-durian-unggul',
            'isi_konten' => '<p>Panduan penerapan sensor IoT cerdas.</p>',
            'tipe_konten' => 'artikel',
        ]);

        $edukasi2 = KontenEdukasi::create([
            'user_id' => $admin->id,
            'kategori_edukasi_id' => $kategori->id,
            'judul' => 'Tips Pemupukan Durian Musang King',
            'slug' => 'tips-pemupukan-durian-musang-king',
            'isi_konten' => '<p>Tips pupuk organik durian.</p>',
            'tipe_konten' => 'artikel',
        ]);

        $response = $this->get(route('edukasi.show', $edukasi1->slug));

        $response->assertOk();
        $response->assertSee('Teknologi Sensor IoT Durian Unggul');
        $response->assertSee('Tips Pemupukan Durian Musang King');
        $response->assertSee('AgriSmart Logo'); // Real footer logo alt
        $response->assertSee('Kembali ke Pusat Edukasi');
    }

    public function test_user_can_directly_input_new_pin_and_device_is_auto_created_and_claimed()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        $response = $this->actingAs($pekebun)->post(route('layanan.claim'), [
            'serial_number' => 'SN-NEW-ESP32-001',
            'pin_code' => '998877',
            'name' => 'Sensor Blok Baru',
        ]);

        $response->assertRedirect(route('layanan.show', 'SN-NEW-ESP32-001'));
        $this->assertDatabaseHas('devices', [
            'serial_number' => 'SN-NEW-ESP32-001',
            'pin_code' => '998877',
            'name' => 'Sensor Blok Baru',
            'user_id' => $pekebun->id,
        ]);
    }

    public function test_existing_device_requires_correct_pin_to_claim()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        \App\Models\Device::create([
            'serial_number' => 'SN-EXISTING-001',
            'pin_code' => '123456',
            'name' => 'Hardware Pre-registered',
            'user_id' => null,
        ]);

        // Salah PIN
        $failResponse = $this->actingAs($pekebun)->post(route('layanan.claim'), [
            'serial_number' => 'SN-EXISTING-001',
            'pin_code' => 'WRONG_PIN',
            'name' => 'Kebun Saya',
        ]);
        $failResponse->assertSessionHas('error');
        $this->assertDatabaseHas('devices', [
            'serial_number' => 'SN-EXISTING-001',
            'user_id' => null,
        ]);

        // Benar PIN
        $okResponse = $this->actingAs($pekebun)->post(route('layanan.claim'), [
            'serial_number' => 'SN-EXISTING-001',
            'pin_code' => '123456',
            'name' => 'Kebun Durian Saya',
        ]);
        $okResponse->assertRedirect(route('layanan.show', 'SN-EXISTING-001'));
        $this->assertDatabaseHas('devices', [
            'serial_number' => 'SN-EXISTING-001',
            'user_id' => $pekebun->id,
            'name' => 'Kebun Durian Saya',
        ]);
    }

    public function test_pekebun_can_access_devices_management_and_upload_batch_pins_directly()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        $indexResponse = $this->actingAs($pekebun)->get(route('layanan.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Hubungkan Sensor');
        $indexResponse->assertSee('Upload Massal');

        // Batch upload via textarea as Pekebun
        $batchText = "SN-BATCH-01, 111222, Sensor Durian Bawor\nSN-BATCH-02, 333444, Sensor Durian Montong";

        $uploadResponse = $this->actingAs($pekebun)->post(route('layanan.upload'), [
            'batch_text' => $batchText,
        ]);

        $uploadResponse->assertRedirect(route('layanan.index'));
        $uploadResponse->assertSessionHas('success');

        $this->assertDatabaseHas('devices', [
            'serial_number' => 'SN-BATCH-01',
            'pin_code'      => '111222',
            'user_id'       => $pekebun->id,
            'name'          => 'Sensor Durian Bawor',
        ]);
        $this->assertDatabaseHas('devices', [
            'serial_number' => 'SN-BATCH-02',
            'pin_code'      => '333444',
            'user_id'       => $pekebun->id,
            'name'          => 'Sensor Durian Montong',
        ]);

        // Pekebun can update device
        $device = Device::where('serial_number', 'SN-BATCH-01')->first();
        $updateResponse = $this->actingAs($pekebun)->put(route('layanan.update', $device->id), [
            'name'          => 'Sensor Durian Bawor Blok Utara',
            'pin_code'      => '999888',
            'serial_number' => 'SN-BATCH-01',
        ]);
        $updateResponse->assertRedirect(route('layanan.index'));
        $this->assertDatabaseHas('devices', [
            'id'       => $device->id,
            'name'     => 'Sensor Durian Bawor Blok Utara',
            'pin_code' => '999888',
        ]);

        // Pekebun can delete device
        $deleteResponse = $this->actingAs($pekebun)->delete(route('layanan.destroy', $device->id));
        $deleteResponse->assertRedirect(route('layanan.index'));
        $this->assertDatabaseMissing('devices', [
            'id' => $device->id,
        ]);
    }

    public function test_pekebun_can_download_device_csv_template()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        $response = $this->actingAs($pekebun)->get(route('layanan.template'));
        $response->assertOk();
        $response->assertHeader('content-disposition', 'attachment; filename="template_upload_perangkat_iot.csv"');
    }

    public function test_admin_navigation_does_not_contain_iot_devices_menu()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertDontSee('Perangkat IoT');
    }

    public function test_market_chat_get_chat_list_returns_json_for_api_and_wants_json_requests()
    {
        $sender = User::factory()->create(['role' => 'user']);
        $receiver = User::factory()->create(['role' => 'pekebun']);

        MarketChat::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Halo pekebun!',
            'is_read' => false,
        ]);

        $responseApi = $this->actingAs($receiver)->getJson('/api/chat');
        $responseApi->assertOk();
        $responseApi->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['user_id', 'name', 'last_message', 'unread_count']
            ]
        ]);

        $responseMarketList = $this->actingAs($receiver)->getJson('/api/market-chat/list');
        $responseMarketList->assertOk();
        $responseMarketList->assertJson(['success' => true]);
    }

    public function test_petani_produk_api_update_blocks_unauthorized_idor_access()
    {
        $owner = User::factory()->create(['role' => 'pekebun']);
        $attacker = User::factory()->create(['role' => 'pekebun']);
        $kategori = KategoriProduk::create(['nama_kategori' => 'Durian Frozen', 'slug' => 'durian-frozen']);

        $produk = Produk::create([
            'user_id' => $owner->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Durian Musang King Frozen',
            'harga' => 250000,
            'stok' => 20,
            'deskripsi' => 'Durian beku kualitas super',
        ]);

        // Attacker attempts to update owner's product via API
        $response = $this->actingAs($attacker)->postJson('/api/petani/produk/' . $produk->id, [
            'nama_produk' => 'Hacked Durian',
            'harga' => 1000,
            'stok' => 999,
            'kategori_produk_id' => $kategori->id,
        ]);

        $response->assertStatus(404);
        $this->assertEquals('Durian Musang King Frozen', $produk->fresh()->nama_produk);
        $this->assertEquals(250000, $produk->fresh()->harga);
    }

    public function test_petani_pesanan_api_update_status_blocks_unauthorized_idor_access()
    {
        $seller = User::factory()->create(['role' => 'pekebun']);
        $attackerSeller = User::factory()->create(['role' => 'pekebun']);
        $buyer = User::factory()->create(['role' => 'user']);
        $kategori = KategoriProduk::create(['nama_kategori' => 'Bibit', 'slug' => 'bibit']);

        $produk = Produk::create([
            'user_id' => $seller->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Bibit Duri Hitam',
            'harga' => 75000,
            'stok' => 15,
            'deskripsi' => 'Bibit unggul',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $buyer->id,
            'kode_pesanan' => 'INV-IDOR-ORDER-01',
            'total_harga' => 150000,
            'status' => 'pending',
            'alamat_kirim' => 'Jl. Kebun No. 9',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk->id,
            'jumlah' => 2,
            'harga_satuan' => 75000,
        ]);

        // Attacker pekebun attempts to update status of an order that has no products belonging to attacker
        $response = $this->actingAs($attackerSeller)->postJson('/api/petani/pesanan/' . $pesanan->id . '/update-status', [
            'status' => 'cancelled',
        ]);

        $response->assertStatus(403);
        $this->assertEquals('pending', $pesanan->fresh()->status);
    }

    public function test_admin_product_update_does_not_mass_assign_unallowed_fields()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $originalOwner = User::factory()->create(['role' => 'pekebun']);
        $kategori = KategoriProduk::create(['nama_kategori' => 'Kategori Asli', 'slug' => 'kategori-asli']);

        $produk = Produk::create([
            'user_id' => $originalOwner->id,
            'kategori_produk_id' => $kategori->id,
            'nama_produk' => 'Durian Montong Asli',
            'harga' => 120000,
            'stok' => 10,
            'deskripsi' => 'Deskripsi Asli',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.products.update', $produk->id), [
            'nama_produk' => 'Durian Montong Edited',
            'harga' => 130000,
            'stok' => 12,
            'deskripsi' => 'Deskripsi Baru',
            'kategori_produk_id' => $kategori->id,
            'user_id' => 99999, // Malicious mass-assignment injection
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals($originalOwner->id, $produk->fresh()->user_id);
        $this->assertEquals('Durian Montong Edited', $produk->fresh()->nama_produk);
    }

    public function test_admin_withdraw_index_works_with_ansi_sql_case()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pekebun = User::factory()->create(['role' => 'pekebun']);

        \App\Models\Withdrawal::create([
            'user_id' => $pekebun->id,
            'jumlah' => 50000,
            'nama_bank' => 'Mandiri',
            'nomor_rekening' => '0987654321',
            'status' => 'approved',
        ]);

        \App\Models\Withdrawal::create([
            'user_id' => $pekebun->id,
            'jumlah' => 75000,
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.withdraw.index'));
        $response->assertOk();
        $response->assertViewHas('requests');
    }

    public function test_pembibitan_tanam_blocks_cross_user_lahan()
    {
        $pekebun1 = User::factory()->create(['role' => 'pekebun']);
        $pekebun2 = User::factory()->create(['role' => 'pekebun']);

        $lahanPekebun2 = \App\Models\Lahan::create([
            'user_id' => $pekebun2->id,
            'nama_lahan' => 'Lahan Pekebun Lain',
            'luas_ha' => 2.5,
            'lokasi' => 'Bukit Selatan',
        ]);

        $bibit = \App\Models\Bibit::create([
            'user_id' => $pekebun1->id,
            'kode_bibit' => 'BIB-TEST-001',
            'nama_varietas' => 'Musang King',
            'jumlah' => 10,
            'status' => 'siap_tanam',
            'kondisi' => 'sehat',
            'tanggal_semai' => now()->toDateString(),
        ]);

        // Pekebun 1 tries to plant into Pekebun 2's lahan
        $response = $this->actingAs($pekebun1)->post(route('portal.pembibitan.bibit.tanam.store', $bibit->id), [
            'jumlah' => 2,
            'lahan_id' => $lahanPekebun2->id,
            'tanggal_tanam' => now()->toDateString(),
        ]);

        $response->assertSessionHasErrors('lahan_id');
        $this->assertEquals(10, $bibit->fresh()->jumlah);
        $this->assertEquals(0, $lahanPekebun2->fresh()->jumlah_pohon ?? 0);
    }

    public function test_iot_auto_mode_automatically_toggles_pump_based_on_soil_moisture()
    {
        $pekebun = User::factory()->create(['role' => 'pekebun']);
        $device = Device::create([
            'user_id' => $pekebun->id,
            'name' => 'Sensor Blok Durian Super',
            'serial_number' => 'ESP32-SMART-PUMP-01',
            'pin_code' => '554433',
            'mode' => 'AUTO',
            'is_pump_on' => false,
        ]);

        // Telemetry 1: Soil moisture < 40% (dry soil) -> pump should turn ON automatically
        $response1 = $this->postJson('/api/iot/receive-data', [
            'serial_number' => $device->serial_number,
            'moisture' => 32.5,
            'temperature' => 31.0,
            'humidity' => 60.0,
        ]);

        $response1->assertOk();
        $response1->assertJson([
            'status' => 'success',
            'mode' => 'AUTO',
            'pump' => 'ON',
        ]);
        $this->assertTrue($device->fresh()->is_pump_on);

        // Telemetry 2: Soil moisture >= 60% (well-watered) -> pump should turn OFF automatically
        $response2 = $this->postJson('/api/iot/receive-data', [
            'serial_number' => $device->serial_number,
            'moisture' => 64.0,
            'temperature' => 29.5,
            'humidity' => 75.0,
        ]);

        $response2->assertOk();
        $response2->assertJson([
            'status' => 'success',
            'mode' => 'AUTO',
            'pump' => 'OFF',
        ]);
        $this->assertFalse($device->fresh()->is_pump_on);
    }

    public function test_notifikasi_api_does_not_leak_debug_keys()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->getJson('/api/notifikasi');

        $response->assertOk();
        $response->assertJsonMissing([
            'debug_user_id',
            'debug_user_name',
            'debug_user_email',
        ]);
    }
}

