<?php

use App\Models\Bibit;
use App\Models\JadwalPerawatanBibit;
use App\Models\MonitoringBibit;
use App\Models\PengadaanBibit;
use App\Models\User;

test('pekebun can access pembibitan dashboard with statistics', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-001',
        'nama_varietas' => 'Musang King',
        'asal_benih'    => 'Sertifikasi Jawa Timur',
        'jumlah'        => 50,
        'status'        => 'aktif',
        'kondisi'       => 'sehat',
        'tanggal_semai' => now()->subDays(10),
    ]);

    $bibitKritis = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-002',
        'nama_varietas' => 'Duri Hitam',
        'asal_benih'    => 'Supplier Lokal',
        'jumlah'        => 10,
        'status'        => 'perawatan',
        'kondisi'       => 'kritis',
        'tanggal_semai' => now()->subDays(20),
    ]);

    $jadwal = JadwalPerawatanBibit::create([
        'user_id'         => $pekebun->id,
        'bibit_id'        => $bibit->id,
        'jenis_perawatan' => 'Penyiraman & Nutrisi AB Mix',
        'tanggal_jadwal'  => now(),
        'status'          => 'pending',
    ]);

    $response = $this->actingAs($pekebun)->get(route('portal.pembibitan.dashboard'));

    $response->assertOk();
    $response->assertSee('Selamat Datang, ' . $pekebun->name);
    $response->assertSee('Musang King');
    $response->assertSee('Duri Hitam');
    $response->assertSee('Penyiraman & Nutrisi AB Mix');
    $response->assertSee('60'); // 50 + 10 total bibit hidup
});

test('pekebun can filter and search bibit list', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-MK',
        'nama_varietas' => 'Musang King',
        'jumlah'        => 20,
        'status'        => 'aktif',
        'kondisi'       => 'sehat',
    ]);

    Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-DH',
        'nama_varietas' => 'Duri Hitam',
        'jumlah'        => 15,
        'status'        => 'siap_tanam',
        'kondisi'       => 'sehat',
    ]);

    $resAll = $this->actingAs($pekebun)->get(route('portal.pembibitan.bibit.index'));
    $resAll->assertOk()->assertSee('Musang King')->assertSee('Duri Hitam');

    $resFilter = $this->actingAs($pekebun)->get(route('portal.pembibitan.bibit.index', ['status' => 'siap_tanam']));
    $resFilter->assertOk()->assertSee('Duri Hitam')->assertDontSee('Musang King');

    $resSearch = $this->actingAs($pekebun)->get(route('portal.pembibitan.bibit.index', ['search' => 'MK']));
    $resSearch->assertOk()->assertSee('Musang King')->assertDontSee('Duri Hitam');
});

test('pekebun can record pengadaan and it updates or creates bibit inventory with asal_benih', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $response = $this->actingAs($pekebun)->post(route('portal.pembibitan.pengadaan.store'), [
        'nama_supplier' => 'PT Benih Unggul',
        'nama_varietas' => 'Bawor Banyumas',
        'jumlah'        => 30,
        'harga_satuan'  => 45000,
        'tanggal'       => now()->format('Y-m-d'),
        'catatan'       => 'Batch pertama kualitas super',
    ]);

    $response->assertRedirect(route('portal.pembibitan.pengadaan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('pengadaan_bibit', [
        'user_id'       => $pekebun->id,
        'nama_supplier' => 'PT Benih Unggul',
        'nama_varietas' => 'Bawor Banyumas',
        'jumlah'        => 30,
    ]);

    $this->assertDatabaseHas('bibit', [
        'user_id'       => $pekebun->id,
        'nama_varietas' => 'Bawor Banyumas',
        'asal_benih'    => 'Pengadaan: PT Benih Unggul',
        'jumlah'        => 30,
        'status'        => 'aktif',
    ]);
});

test('pekebun can mark perawatan schedule as selesai from dashboard or schedule page', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-010',
        'nama_varietas' => 'Super Tembaga',
        'jumlah'        => 10,
        'status'        => 'aktif',
        'kondisi'       => 'sehat',
    ]);

    $jadwal = JadwalPerawatanBibit::create([
        'user_id'         => $pekebun->id,
        'bibit_id'        => $bibit->id,
        'jenis_perawatan' => 'Semprot Fungisida Organik',
        'tanggal_jadwal'  => now(),
        'status'          => 'pending',
    ]);

    $response = $this->actingAs($pekebun)->patch(route('portal.pembibitan.jadwal.selesai', $jadwal));

    $response->assertSessionHas('success');
    $jadwal->refresh();
    expect($jadwal->status)->toBe('selesai');
});

test('pekebun can record monitoring and it updates bibit condition', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-020',
        'nama_varietas' => 'Ochee D200',
        'jumlah'        => 15,
        'status'        => 'aktif',
        'kondisi'       => 'kurang_sehat',
    ]);

    $response = $this->actingAs($pekebun)->post(route('portal.pembibitan.monitoring.store'), [
        'bibit_id'  => $bibit->id,
        'tinggi_cm' => 42.5,
        'kondisi'   => 'sehat',
        'tanggal'   => now()->format('Y-m-d'),
        'catatan'   => 'Tunas baru tumbuh subur setelah pemupukan',
    ]);

    $response->assertRedirect(route('portal.pembibitan.monitoring.index'));
    $bibit->refresh();

    expect($bibit->kondisi)->toBe('sehat');
    $this->assertDatabaseHas('monitoring_bibit', [
        'bibit_id'  => $bibit->id,
        'tinggi_cm' => 42.5,
        'kondisi'   => 'sehat',
    ]);
});

test('pekebun can view pembibitan laporan aggregation correctly', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-L1',
        'nama_varietas' => 'Musang King',
        'jumlah'        => 50,
        'status'        => 'aktif',
        'kondisi'       => 'sehat',
    ]);

    Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-L2',
        'nama_varietas' => 'Bawor',
        'jumlah'        => 25,
        'status'        => 'siap_tanam',
        'kondisi'       => 'sehat',
    ]);

    $response = $this->actingAs($pekebun)->get(route('portal.pembibitan.laporan'));

    $response->assertOk();
    $response->assertSee('50 bibit');
    $response->assertSee('25 bibit');
    $response->assertSee('75 bibit'); // sum of sehat
});

test('pekebun can transfer siap_tanam bibit to lahan', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $lahan = \App\Models\Lahan::create([
        'user_id' => $pekebun->id,
        'nama_lahan' => 'Blok A Bukit',
        'luas_ha' => 2.5,
        'lokasi' => 'Lereng Timur',
        'jumlah_pohon' => 0,
    ]);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-TNM',
        'nama_varietas' => 'Musang King',
        'jumlah'        => 5,
        'status'        => 'siap_tanam',
        'kondisi'       => 'sehat',
    ]);

    $response = $this->actingAs($pekebun)->post(route('portal.pembibitan.bibit.tanam.store', $bibit), [
        'jumlah' => 2,
        'lahan_id' => $lahan->id,
        'tanggal_tanam' => now()->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('portal.pertumbuhan.pohon.index'));
    $bibit->refresh();
    $lahan->refresh();

    expect($bibit->jumlah)->toBe(3);
    expect($lahan->jumlah_pohon)->toBe(2);
    $this->assertDatabaseHas('pohon_durian', [
        'user_id' => $pekebun->id,
        'lahan_id' => $lahan->id,
        'nama_varietas' => 'Musang King',
        'bibit_id' => $bibit->id,
    ]);
});

test('pekebun can edit and delete pengadaan', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $pengadaan = PengadaanBibit::create([
        'user_id'       => $pekebun->id,
        'nama_supplier' => 'CV Sumber Bibit',
        'nama_varietas' => 'Musang King',
        'jumlah'        => 10,
        'harga_satuan'  => 50000,
        'tanggal'       => now()->format('Y-m-d'),
    ]);

    // Test edit form
    $this->actingAs($pekebun)->get(route('portal.pembibitan.pengadaan.edit', $pengadaan))->assertOk();

    // Test update
    $response = $this->actingAs($pekebun)->put(route('portal.pembibitan.pengadaan.update', $pengadaan), [
        'nama_supplier' => 'CV Sumber Bibit Unggul',
        'nama_varietas' => 'Musang King Super',
        'jumlah'        => 12,
        'harga_satuan'  => 55000,
        'tanggal'       => now()->format('Y-m-d'),
    ]);
    $response->assertRedirect(route('portal.pembibitan.pengadaan.index'));

    $pengadaan->refresh();
    expect($pengadaan->nama_supplier)->toBe('CV Sumber Bibit Unggul');
    expect($pengadaan->jumlah)->toBe(12);

    // Test delete
    $delResponse = $this->actingAs($pekebun)->delete(route('portal.pembibitan.pengadaan.destroy', $pengadaan));
    $delResponse->assertSessionHas('success');
    $this->assertDatabaseMissing('pengadaan_bibit', ['id' => $pengadaan->id]);
});

test('pekebun can edit and delete monitoring', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-M1',
        'nama_varietas' => 'Duri Hitam',
        'jumlah'        => 10,
        'status'        => 'aktif',
        'kondisi'       => 'sehat',
    ]);

    $monitoring = MonitoringBibit::create([
        'user_id'   => $pekebun->id,
        'bibit_id'  => $bibit->id,
        'tinggi_cm' => 35.0,
        'kondisi'   => 'sehat',
        'tanggal'   => now()->format('Y-m-d'),
    ]);

    // Test edit form
    $this->actingAs($pekebun)->get(route('portal.pembibitan.monitoring.edit', $monitoring))->assertOk();

    // Test update
    $response = $this->actingAs($pekebun)->put(route('portal.pembibitan.monitoring.update', $monitoring), [
        'bibit_id'  => $bibit->id,
        'tinggi_cm' => 40.0,
        'kondisi'   => 'kurang_sehat',
        'tanggal'   => now()->format('Y-m-d'),
    ]);
    $response->assertRedirect(route('portal.pembibitan.monitoring.index'));

    $monitoring->refresh();
    $bibit->refresh();
    expect((float) $monitoring->tinggi_cm)->toBe(40.0);
    expect($bibit->kondisi)->toBe('kurang_sehat');

    // Test delete
    $delResponse = $this->actingAs($pekebun)->delete(route('portal.pembibitan.monitoring.destroy', $monitoring));
    $delResponse->assertSessionHas('success');
    $this->assertDatabaseMissing('monitoring_bibit', ['id' => $monitoring->id]);
});

test('pekebun can edit and delete jadwal perawatan', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-J1',
        'nama_varietas' => 'Bawor',
        'jumlah'        => 8,
        'status'        => 'aktif',
        'kondisi'       => 'sehat',
    ]);

    $jadwal = JadwalPerawatanBibit::create([
        'user_id'         => $pekebun->id,
        'bibit_id'        => $bibit->id,
        'jenis_perawatan' => 'Penyiraman Pagi',
        'tanggal_jadwal'  => now(),
        'status'          => 'pending',
    ]);

    // Test edit form
    $this->actingAs($pekebun)->get(route('portal.pembibitan.jadwal.edit', $jadwal))->assertOk();

    // Test update
    $response = $this->actingAs($pekebun)->put(route('portal.pembibitan.jadwal.update', $jadwal), [
        'bibit_id'        => $bibit->id,
        'jenis_perawatan' => 'Penyiraman Sore & AB Mix',
        'tanggal_jadwal'  => now()->addDays(1)->format('Y-m-d'),
        'status'          => 'pending',
    ]);
    $response->assertRedirect(route('portal.pembibitan.jadwal.index'));

    $jadwal->refresh();
    expect($jadwal->jenis_perawatan)->toBe('Penyiraman Sore & AB Mix');

    // Test delete
    $delResponse = $this->actingAs($pekebun)->delete(route('portal.pembibitan.jadwal.destroy', $jadwal));
    $delResponse->assertSessionHas('success');
    $this->assertDatabaseMissing('jadwal_perawatan_bibit', ['id' => $jadwal->id]);
});

test('dashboard renders edit and delete actions for activities', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-CRIT',
        'nama_varietas' => 'Durian Runtuh',
        'jumlah'        => 5,
        'status'        => 'aktif',
        'kondisi'       => 'kritis',
    ]);

    $jadwal = JadwalPerawatanBibit::create([
        'user_id'         => $pekebun->id,
        'bibit_id'        => $bibit->id,
        'jenis_perawatan' => 'Pemberian Hormon Akar',
        'tanggal_jadwal'  => now(),
        'status'          => 'pending',
    ]);

    $monitoring = MonitoringBibit::create([
        'user_id'   => $pekebun->id,
        'bibit_id'  => $bibit->id,
        'tinggi_cm' => 28.5,
        'kondisi'   => 'kritis',
        'tanggal'   => now()->format('Y-m-d'),
    ]);

    $pengadaan = PengadaanBibit::create([
        'user_id'       => $pekebun->id,
        'nama_supplier' => 'Toko Bibit Hijau',
        'nama_varietas' => 'Durian Runtuh',
        'jumlah'        => 5,
        'harga_satuan'  => 60000,
        'tanggal'       => now()->format('Y-m-d'),
    ]);

    $response = $this->actingAs($pekebun)->get(route('portal.pembibitan.dashboard'));

    $response->assertOk();
    // Edit links exist on dashboard for the entities
    $response->assertSee(route('portal.pembibitan.jadwal.edit', $jadwal));
    $response->assertSee(route('portal.pembibitan.bibit.edit', $bibit));
    $response->assertSee(route('portal.pembibitan.monitoring.edit', $monitoring));
    $response->assertSee(route('portal.pembibitan.pengadaan.edit', $pengadaan));

    // Delete actions exist on dashboard for the entities
    $response->assertSee(route('portal.pembibitan.jadwal.destroy', $jadwal));
    $response->assertSee(route('portal.pembibitan.bibit.destroy', $bibit));
    $response->assertSee(route('portal.pembibitan.monitoring.destroy', $monitoring));
    $response->assertSee(route('portal.pembibitan.pengadaan.destroy', $pengadaan));
});


