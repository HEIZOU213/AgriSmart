<?php

use App\Models\JadwalPerawatanPohon;
use App\Models\Lahan;
use App\Models\MonitoringPertumbuhan;
use App\Models\PohonDurian;
use App\Models\User;

test('pekebun can access pertumbuhan dashboard with statistics and items', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $pohonSehat = PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-001',
        'nama_varietas' => 'Musang King',
        'lokasi'        => 'Blok A-1',
        'fase'          => 'produktif',
        'kondisi'       => 'sehat',
        'tanggal_tanam' => now()->subYears(4),
    ]);

    $pohonKritis = PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-002',
        'nama_varietas' => 'Bawor Super',
        'lokasi'        => 'Blok B-3',
        'fase'          => 'vegetatif',
        'kondisi'       => 'bermasalah',
        'tanggal_tanam' => now()->subYears(1),
    ]);

    $jadwal = JadwalPerawatanPohon::create([
        'user_id'         => $pekebun->id,
        'pohon_id'        => $pohonKritis->id,
        'jenis_perawatan' => 'Penyemprotan Insektisida Hama Penggerek',
        'tanggal_jadwal'  => now(),
        'status'          => 'pending',
    ]);

    $monitoring = MonitoringPertumbuhan::create([
        'user_id'         => $pekebun->id,
        'pohon_id'        => $pohonSehat->id,
        'tinggi_cm'       => 285.5,
        'diameter_batang' => 18.2,
        'jumlah_cabang'   => 14,
        'kondisi'         => 'sehat',
        'tanggal'         => now(),
        'catatan'         => 'Pohon tumbuh sangat baik dan subur',
    ]);

    $response = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.dashboard'));

    $response->assertOk();
    $response->assertSee('Selamat Datang, ' . $pekebun->name);
    $response->assertSee('Musang King');
    $response->assertSee('Bawor Super');
    $response->assertSee('Penyemprotan Insektisida Hama Penggerek');
    $response->assertSee('Pohon tumbuh sangat baik dan subur');
    $response->assertSee('285.5 cm');
});

test('pertumbuhan dashboard renders action buttons for jadwal, pohon, and monitoring', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $pohon = PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-ACT',
        'nama_varietas' => 'Black Thorn',
        'fase'          => 'vegetatif',
        'kondisi'       => 'perawatan',
    ]);

    $jadwal = JadwalPerawatanPohon::create([
        'user_id'         => $pekebun->id,
        'pohon_id'        => $pohon->id,
        'jenis_perawatan' => 'Pemupukan NPK Booster',
        'tanggal_jadwal'  => now()->addDay(),
        'status'          => 'pending',
    ]);

    $monitoring = MonitoringPertumbuhan::create([
        'user_id'   => $pekebun->id,
        'pohon_id'  => $pohon->id,
        'kondisi'   => 'perawatan',
        'tanggal'   => now(),
    ]);

    $response = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.dashboard'));
    $response->assertOk();

    // Jadwal action buttons: Selesai, Edit, Hapus
    $response->assertSee(route('portal.pertumbuhan.jadwal.selesai', $jadwal));
    $response->assertSee(route('portal.pertumbuhan.jadwal.edit', $jadwal));
    $response->assertSee(route('portal.pertumbuhan.jadwal.destroy', $jadwal));

    // Pohon perhatian action buttons: Monitoring, Edit, Hapus
    $response->assertSee(route('portal.pertumbuhan.monitoring.create', ['pohon_id' => $pohon->id]));
    $response->assertSee(route('portal.pertumbuhan.pohon.edit', $pohon));
    $response->assertSee(route('portal.pertumbuhan.pohon.destroy', $pohon));

    // Monitoring action buttons: Edit, Hapus
    $response->assertSee(route('portal.pertumbuhan.monitoring.edit', $monitoring));
    $response->assertSee(route('portal.pertumbuhan.monitoring.destroy', $monitoring));
});

test('pekebun can filter and search pohon durian list', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-MK-01',
        'nama_varietas' => 'Musang King',
        'lokasi'        => 'Zona Timur',
        'fase'          => 'produktif',
        'kondisi'       => 'sehat',
    ]);

    PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-BT-02',
        'nama_varietas' => 'Black Thorn',
        'lokasi'        => 'Zona Barat',
        'fase'          => 'bibit',
        'kondisi'       => 'bermasalah',
    ]);

    // All trees
    $resAll = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.pohon.index'));
    $resAll->assertOk()->assertSee('Musang King')->assertSee('Black Thorn');

    // Filter by kondisi
    $resKondisi = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.pohon.index', ['kondisi' => 'bermasalah']));
    $resKondisi->assertOk()->assertSee('Black Thorn')->assertDontSee('Musang King');

    // Filter by fase
    $resFase = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.pohon.index', ['fase' => 'produktif']));
    $resFase->assertOk()->assertSee('Musang King')->assertDontSee('Black Thorn');

    // Search by keyword
    $resSearch = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.pohon.index', ['search' => 'Timur']));
    $resSearch->assertOk()->assertSee('Musang King')->assertDontSee('Black Thorn');
});

test('pekebun can create, edit, and delete pohon durian', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);
    $lahan = Lahan::create([
        'user_id'      => $pekebun->id,
        'nama_lahan'   => 'Lahan Bukit Durian',
        'lokasi'       => 'Desa Sukamaju',
        'luas_ha'      => 2.5,
        'jumlah_pohon' => 0,
        'kondisi'      => 'baik',
    ]);

    // CREATE
    $resCreate = $this->actingAs($pekebun)->post(route('portal.pertumbuhan.pohon.store'), [
        'kode_pohon'    => 'PHN-NW-01',
        'nama_varietas' => 'Ochee Durian Hitam',
        'lokasi'        => 'Baris 3 No 4',
        'lahan_id'      => $lahan->id,
        'fase'          => 'vegetatif',
        'kondisi'       => 'sehat',
        'tanggal_tanam' => now()->format('Y-m-d'),
        'catatan'       => 'Bibit unggul okulasi',
    ]);

    $resCreate->assertRedirect(route('portal.pertumbuhan.pohon.index'));
    $this->assertDatabaseHas('pohon_durian', [
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-NW-01',
        'nama_varietas' => 'Ochee Durian Hitam',
    ]);

    // Check lahan counter incremented
    expect($lahan->fresh()->jumlah_pohon)->toBe(1);

    $pohon = PohonDurian::where('kode_pohon', 'PHN-NW-01')->first();

    // EDIT FORM
    $resEditForm = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.pohon.edit', $pohon));
    $resEditForm->assertOk()->assertSee('Ochee Durian Hitam');

    // UPDATE
    $resUpdate = $this->actingAs($pekebun)->put(route('portal.pertumbuhan.pohon.update', $pohon), [
        'kode_pohon'    => 'PHN-NW-01',
        'nama_varietas' => 'Ochee Super Premium',
        'lokasi'        => 'Baris 3 No 4',
        'lahan_id'      => $lahan->id,
        'fase'          => 'generatif',
        'kondisi'       => 'perawatan',
        'tanggal_tanam' => now()->format('Y-m-d'),
        'catatan'       => 'Mulai muncul bunga',
    ]);

    $resUpdate->assertRedirect(route('portal.pertumbuhan.pohon.index'));
    $this->assertDatabaseHas('pohon_durian', [
        'id'            => $pohon->id,
        'nama_varietas' => 'Ochee Super Premium',
        'fase'          => 'generatif',
        'kondisi'       => 'perawatan',
    ]);

    // DELETE
    $resDelete = $this->actingAs($pekebun)->delete(route('portal.pertumbuhan.pohon.destroy', $pohon));
    $resDelete->assertRedirect();
    $this->assertDatabaseMissing('pohon_durian', ['id' => $pohon->id]);
    expect($lahan->fresh()->jumlah_pohon)->toBe(0);
});

test('pekebun can create, edit, and delete monitoring and it synchronizes pohon condition', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);
    $pohon = PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-MON-1',
        'nama_varietas' => 'Montong Kani',
        'fase'          => 'vegetatif',
        'kondisi'       => 'sehat',
    ]);

    // CREATE MONITORING (changes condition to perawatan)
    $resCreate = $this->actingAs($pekebun)->post(route('portal.pertumbuhan.monitoring.store'), [
        'pohon_id'        => $pohon->id,
        'tinggi_cm'       => 150.5,
        'diameter_batang' => 8.4,
        'jumlah_cabang'   => 6,
        'kondisi'         => 'perawatan',
        'tanggal'         => now()->format('Y-m-d'),
        'catatan'         => 'Terlihat ada jamur upas di batang utama',
    ]);

    $resCreate->assertRedirect(route('portal.pertumbuhan.monitoring.index'));
    $this->assertDatabaseHas('monitoring_pertumbuhan', [
        'user_id'  => $pekebun->id,
        'pohon_id' => $pohon->id,
        'kondisi'  => 'perawatan',
    ]);

    // Pohon condition updated
    expect($pohon->fresh()->kondisi)->toBe('perawatan');

    $monitoring = MonitoringPertumbuhan::where('pohon_id', $pohon->id)->first();

    // EDIT FORM
    $resEditForm = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.monitoring.edit', $monitoring));
    $resEditForm->assertOk()->assertSee('150.5');

    // UPDATE MONITORING (recovery to sehat)
    $resUpdate = $this->actingAs($pekebun)->put(route('portal.pertumbuhan.monitoring.update', $monitoring), [
        'pohon_id'        => $pohon->id,
        'tinggi_cm'       => 155.0,
        'diameter_batang' => 8.8,
        'jumlah_cabang'   => 7,
        'kondisi'         => 'sehat',
        'tanggal'         => now()->format('Y-m-d'),
        'catatan'         => 'Jamur teratasi setelah disemprot fungisida tembaga',
    ]);

    $resUpdate->assertRedirect(route('portal.pertumbuhan.monitoring.index'));
    expect($pohon->fresh()->kondisi)->toBe('sehat');

    // DELETE MONITORING
    $resDelete = $this->actingAs($pekebun)->delete(route('portal.pertumbuhan.monitoring.destroy', $monitoring));
    $resDelete->assertRedirect();
    $this->assertDatabaseMissing('monitoring_pertumbuhan', ['id' => $monitoring->id]);
});

test('pekebun can create, edit, mark complete, and delete jadwal perawatan pohon', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);
    $pohon = PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-JDW-1',
        'nama_varietas' => 'Bawor',
        'fase'          => 'generatif',
        'kondisi'       => 'sehat',
    ]);

    // CREATE JADWAL
    $resCreate = $this->actingAs($pekebun)->post(route('portal.pertumbuhan.jadwal.store'), [
        'pohon_id'        => $pohon->id,
        'jenis_perawatan' => 'Pemupukan Kalium Nitrat (KNO3)',
        'tanggal_jadwal'  => now()->addDays(2)->format('Y-m-d'),
        'catatan'         => 'Dosis 250 gram dilarutkan ke 20L air',
    ]);

    $resCreate->assertRedirect(route('portal.pertumbuhan.jadwal.index'));
    $this->assertDatabaseHas('jadwal_perawatan_pohon', [
        'user_id'         => $pekebun->id,
        'pohon_id'        => $pohon->id,
        'jenis_perawatan' => 'Pemupukan Kalium Nitrat (KNO3)',
        'status'          => 'pending',
    ]);

    $jadwal = JadwalPerawatanPohon::where('pohon_id', $pohon->id)->first();

    // EDIT FORM
    $resEditForm = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.jadwal.edit', $jadwal));
    $resEditForm->assertOk()->assertSee('Pemupukan Kalium Nitrat (KNO3)');

    // UPDATE JADWAL
    $resUpdate = $this->actingAs($pekebun)->put(route('portal.pertumbuhan.jadwal.update', $jadwal), [
        'pohon_id'        => $pohon->id,
        'jenis_perawatan' => 'Pemupukan Kalium Nitrat (KNO3) + MKP',
        'tanggal_jadwal'  => now()->addDays(3)->format('Y-m-d'),
        'status'          => 'pending',
        'catatan'         => 'Tambahkan MKP 100 gram',
    ]);

    $resUpdate->assertRedirect(route('portal.pertumbuhan.jadwal.index'));
    $this->assertDatabaseHas('jadwal_perawatan_pohon', [
        'id'              => $jadwal->id,
        'jenis_perawatan' => 'Pemupukan Kalium Nitrat (KNO3) + MKP',
    ]);

    // MARK SELESAI
    $resSelesai = $this->actingAs($pekebun)->patch(route('portal.pertumbuhan.jadwal.selesai', $jadwal));
    $resSelesai->assertRedirect();
    expect($jadwal->fresh()->status)->toBe('selesai');

    // DELETE JADWAL
    $resDelete = $this->actingAs($pekebun)->delete(route('portal.pertumbuhan.jadwal.destroy', $jadwal));
    $resDelete->assertRedirect();
    $this->assertDatabaseMissing('jadwal_perawatan_pohon', ['id' => $jadwal->id]);
});

test('pekebun cannot edit or delete another pekebun resources (403 abort)', function () {
    $pekebun1 = User::factory()->create(['role' => 'pekebun']);
    $pekebun2 = User::factory()->create(['role' => 'pekebun']);

    $pohon = PohonDurian::create([
        'user_id'       => $pekebun1->id,
        'kode_pohon'    => 'PHN-SEC',
        'nama_varietas' => 'Durian Rahasia',
        'fase'          => 'vegetatif',
        'kondisi'       => 'sehat',
    ]);

    $monitoring = MonitoringPertumbuhan::create([
        'user_id'   => $pekebun1->id,
        'pohon_id'  => $pohon->id,
        'kondisi'   => 'sehat',
        'tanggal'   => now(),
    ]);

    $jadwal = JadwalPerawatanPohon::create([
        'user_id'         => $pekebun1->id,
        'pohon_id'        => $pohon->id,
        'jenis_perawatan' => 'Perawatan Rahasia',
        'tanggal_jadwal'  => now(),
        'status'          => 'pending',
    ]);

    // Pekebun2 trying to edit/delete Pekebun1's pohon
    $this->actingAs($pekebun2)->get(route('portal.pertumbuhan.pohon.edit', $pohon))->assertForbidden();
    $this->actingAs($pekebun2)->delete(route('portal.pertumbuhan.pohon.destroy', $pohon))->assertForbidden();

    // Pekebun2 trying to edit/delete Pekebun1's monitoring
    $this->actingAs($pekebun2)->get(route('portal.pertumbuhan.monitoring.edit', $monitoring))->assertForbidden();
    $this->actingAs($pekebun2)->delete(route('portal.pertumbuhan.monitoring.destroy', $monitoring))->assertForbidden();

    // Pekebun2 trying to edit/delete Pekebun1's jadwal
    $this->actingAs($pekebun2)->get(route('portal.pertumbuhan.jadwal.edit', $jadwal))->assertForbidden();
    $this->actingAs($pekebun2)->delete(route('portal.pertumbuhan.jadwal.destroy', $jadwal))->assertForbidden();
    $this->actingAs($pekebun2)->patch(route('portal.pertumbuhan.jadwal.selesai', $jadwal))->assertForbidden();
});

test('pekebun can access fase and laporan pages', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    PohonDurian::create([
        'user_id'       => $pekebun->id,
        'kode_pohon'    => 'PHN-FAS',
        'nama_varietas' => 'Musang King Super',
        'fase'          => 'produktif',
        'kondisi'       => 'sehat',
    ]);

    $this->actingAs($pekebun)->get(route('portal.pertumbuhan.fase'))
        ->assertOk()
        ->assertSee('Musang King Super')
        ->assertSee('Fase Produktif');

    $this->actingAs($pekebun)->get(route('portal.pertumbuhan.laporan'))
        ->assertOk()
        ->assertSee('Rekap Pertumbuhan Pohon')
        ->assertSee('produktif');
});
