<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lahan;
use App\Models\StokBarang;
use App\Models\HasilPanen;
use App\Models\BiayaOperasional;
use App\Models\JadwalKebun;
use App\Models\PohonDurian;
use App\Models\Bibit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManajemenPortalTest extends TestCase
{
    use RefreshDatabase;

    private User $pekebun;
    private User $otherPekebun;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pekebun = User::factory()->create([
            'role' => 'pekebun',
        ]);

        $this->otherPekebun = User::factory()->create([
            'role' => 'pekebun',
        ]);
    }

    public function test_pekebun_can_access_manajemen_dashboard_with_all_statistics()
    {
        $lahan = Lahan::create([
            'user_id'      => $this->pekebun->id,
            'nama_lahan'   => 'Blok A Sentosa',
            'luas_ha'      => 2.5,
            'kondisi'      => 'baik',
            'jumlah_pohon' => 50,
        ]);

        PohonDurian::create([
            'user_id'       => $this->pekebun->id,
            'lahan_id'      => $lahan->id,
            'kode_pohon'    => 'PHN-001',
            'nama_varietas' => 'Musang King',
            'tanggal_tanam' => now()->subYears(3),
            'kondisi'       => 'sehat',
            'fase'          => 'produktif',
        ]);

        StokBarang::create([
            'user_id'      => $this->pekebun->id,
            'nama_barang'  => 'Pupuk NPK 16-16-16',
            'kategori'     => 'Pupuk',
            'jumlah'       => 3,
            'satuan'       => 'Sak',
            'harga_satuan' => 450000,
        ]);

        HasilPanen::create([
            'user_id'       => $this->pekebun->id,
            'lahan_id'      => $lahan->id,
            'varietas'      => 'Musang King',
            'jumlah_kg'     => 120.5,
            'harga_per_kg'  => 150000,
            'tanggal_panen' => now(),
        ]);

        BiayaOperasional::create([
            'user_id'     => $this->pekebun->id,
            'jenis_biaya' => 'Upah Tenaga Kerja',
            'jumlah'      => 750000,
            'tanggal'     => now(),
        ]);

        JadwalKebun::create([
            'user_id'         => $this->pekebun->id,
            'lahan_id'        => $lahan->id,
            'jenis_aktivitas' => 'Pembersihan Gulma',
            'tanggal'         => now()->addDays(2),
            'status'          => 'pending',
        ]);

        $response = $this->actingAs($this->pekebun)->get(route('portal.manajemen.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Blok A Sentosa');
        $response->assertSee('Pupuk NPK 16-16-16');
        $response->assertSee('Pembersihan Gulma');
        $response->assertSee('Musang King');
    }

    public function test_pekebun_can_create_edit_update_and_delete_lahan()
    {
        // 1. Create
        $response = $this->actingAs($this->pekebun)->post(route('portal.manajemen.lahan.store'), [
            'nama_lahan'   => 'Kebun Durian Lereng',
            'luas_ha'      => 1.75,
            'kondisi'      => 'baik',
            'jumlah_pohon' => 30,
            'lokasi'       => 'Kecamatan Cisarua',
            'catatan'      => 'Tanah subur berpasir',
        ]);
        $response->assertRedirect(route('portal.manajemen.lahan.index'));
        $this->assertDatabaseHas('lahan', [
            'user_id'    => $this->pekebun->id,
            'nama_lahan' => 'Kebun Durian Lereng',
        ]);

        $lahan = Lahan::where('nama_lahan', 'Kebun Durian Lereng')->first();

        // 2. Edit View
        $editResponse = $this->actingAs($this->pekebun)->get(route('portal.manajemen.lahan.edit', $lahan));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Kebun Durian Lereng');

        // 3. Update
        $updateResponse = $this->actingAs($this->pekebun)->put(route('portal.manajemen.lahan.update', $lahan), [
            'nama_lahan'   => 'Kebun Durian Lereng Updated',
            'luas_ha'      => 2.0,
            'kondisi'      => 'sedang',
            'jumlah_pohon' => 35,
        ]);
        $updateResponse->assertRedirect(route('portal.manajemen.lahan.index'));
        $this->assertDatabaseHas('lahan', [
            'id'         => $lahan->id,
            'nama_lahan' => 'Kebun Durian Lereng Updated',
            'kondisi'    => 'sedang',
        ]);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->pekebun)->delete(route('portal.manajemen.lahan.destroy', $lahan));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('lahan', ['id' => $lahan->id]);
    }

    public function test_pekebun_can_create_edit_update_and_delete_jadwal_kebun()
    {
        // 1. Create
        $response = $this->actingAs($this->pekebun)->post(route('portal.manajemen.jadwal.store'), [
            'jenis_aktivitas' => 'Pengecekan Saluran Air',
            'tanggal'         => now()->addDays(3)->format('Y-m-d'),
            'catatan'         => 'Pastikan pipa tidak bocor',
        ]);
        $response->assertRedirect(route('portal.manajemen.jadwal.index'));
        $this->assertDatabaseHas('jadwal_kebun', [
            'user_id'         => $this->pekebun->id,
            'jenis_aktivitas' => 'Pengecekan Saluran Air',
            'status'          => 'pending',
        ]);

        $jadwal = JadwalKebun::where('jenis_aktivitas', 'Pengecekan Saluran Air')->first();

        // 2. Edit View
        $editResponse = $this->actingAs($this->pekebun)->get(route('portal.manajemen.jadwal.edit', $jadwal));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Pengecekan Saluran Air');

        // 3. Update
        $updateResponse = $this->actingAs($this->pekebun)->put(route('portal.manajemen.jadwal.update', $jadwal), [
            'jenis_aktivitas' => 'Pengecekan Saluran Air & Valve',
            'tanggal'         => now()->addDays(4)->format('Y-m-d'),
            'status'          => 'pending',
            'catatan'         => 'Valve diganti yang baru',
        ]);
        $updateResponse->assertRedirect(route('portal.manajemen.jadwal.index'));
        $this->assertDatabaseHas('jadwal_kebun', [
            'id'              => $jadwal->id,
            'jenis_aktivitas' => 'Pengecekan Saluran Air & Valve',
        ]);

        // 4. Mark Selesai
        $finishResponse = $this->actingAs($this->pekebun)->patch(route('portal.manajemen.jadwal.selesai', $jadwal));
        $finishResponse->assertRedirect();
        $this->assertEquals('selesai', $jadwal->fresh()->status);

        // 5. Delete
        $deleteResponse = $this->actingAs($this->pekebun)->delete(route('portal.manajemen.jadwal.destroy', $jadwal));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('jadwal_kebun', ['id' => $jadwal->id]);
    }

    public function test_pekebun_can_create_edit_update_and_delete_biaya_operasional()
    {
        // 1. Create
        $response = $this->actingAs($this->pekebun)->post(route('portal.manajemen.biaya.store'), [
            'jenis_biaya' => 'Pembelian Pestisida Alami',
            'jumlah'      => 320000,
            'tanggal'     => now()->format('Y-m-d'),
            'catatan'     => 'Toko Tani Subur',
        ]);
        $response->assertRedirect(route('portal.manajemen.biaya.index'));
        $this->assertDatabaseHas('biaya_operasional', [
            'user_id'     => $this->pekebun->id,
            'jenis_biaya' => 'Pembelian Pestisida Alami',
            'jumlah'      => 320000,
        ]);

        $biaya = BiayaOperasional::where('jenis_biaya', 'Pembelian Pestisida Alami')->first();

        // 2. Edit View
        $editResponse = $this->actingAs($this->pekebun)->get(route('portal.manajemen.biaya.edit', $biaya));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Pembelian Pestisida Alami');

        // 3. Update
        $updateResponse = $this->actingAs($this->pekebun)->put(route('portal.manajemen.biaya.update', $biaya), [
            'jenis_biaya' => 'Pembelian Pestisida & Fungisida',
            'jumlah'      => 450000,
            'tanggal'     => now()->format('Y-m-d'),
        ]);
        $updateResponse->assertRedirect(route('portal.manajemen.biaya.index'));
        $this->assertDatabaseHas('biaya_operasional', [
            'id'     => $biaya->id,
            'jumlah' => 450000,
        ]);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->pekebun)->delete(route('portal.manajemen.biaya.destroy', $biaya));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('biaya_operasional', ['id' => $biaya->id]);
    }

    public function test_pekebun_can_create_edit_update_and_delete_panen()
    {
        // 1. Create
        $response = $this->actingAs($this->pekebun)->post(route('portal.manajemen.panen.store'), [
            'varietas'      => 'Duri Hitam / Ochee',
            'jumlah_kg'     => 85.5,
            'harga_per_kg'  => 250000,
            'tanggal_panen' => now()->format('Y-m-d'),
            'catatan'       => 'Panen perdana pohon nomor 5',
        ]);
        $response->assertRedirect(route('portal.manajemen.panen.index'));
        $this->assertDatabaseHas('hasil_panen', [
            'user_id'   => $this->pekebun->id,
            'varietas'  => 'Duri Hitam / Ochee',
            'jumlah_kg' => 85.5,
        ]);

        $panen = HasilPanen::where('varietas', 'Duri Hitam / Ochee')->first();

        // 2. Edit View
        $editResponse = $this->actingAs($this->pekebun)->get(route('portal.manajemen.panen.edit', $panen));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Duri Hitam / Ochee');

        // 3. Update
        $updateResponse = $this->actingAs($this->pekebun)->put(route('portal.manajemen.panen.update', $panen), [
            'varietas'      => 'Duri Hitam / Ochee Grade A',
            'jumlah_kg'     => 90.0,
            'harga_per_kg'  => 260000,
            'tanggal_panen' => now()->format('Y-m-d'),
        ]);
        $updateResponse->assertRedirect(route('portal.manajemen.panen.index'));
        $this->assertDatabaseHas('hasil_panen', [
            'id'        => $panen->id,
            'varietas'  => 'Duri Hitam / Ochee Grade A',
            'jumlah_kg' => 90.0,
        ]);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->pekebun)->delete(route('portal.manajemen.panen.destroy', $panen));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('hasil_panen', ['id' => $panen->id]);
    }

    public function test_pekebun_can_view_manajemen_laporan_aggregation()
    {
        HasilPanen::create([
            'user_id'       => $this->pekebun->id,
            'varietas'      => 'Bawor Banyumas',
            'jumlah_kg'     => 200,
            'harga_per_kg'  => 100000,
            'tanggal_panen' => now(),
        ]);

        BiayaOperasional::create([
            'user_id'     => $this->pekebun->id,
            'jenis_biaya' => 'Bahan Bakar Mesin Pompa',
            'jumlah'      => 500000,
            'tanggal'     => now(),
        ]);

        $response = $this->actingAs($this->pekebun)->get(route('portal.manajemen.laporan'));
        $response->assertStatus(200);
        $response->assertSee('Bawor Banyumas');
        $response->assertSee('Bahan Bakar Mesin Pompa');
        $response->assertSee('200');
    }

    public function test_pekebun_cannot_modify_or_delete_other_pekebun_manajemen_resources()
    {
        $otherLahan = Lahan::create([
            'user_id'    => $this->otherPekebun->id,
            'nama_lahan' => 'Lahan Rahasia',
            'luas_ha'    => 5.0,
            'kondisi'    => 'baik',
        ]);

        $otherJadwal = JadwalKebun::create([
            'user_id'         => $this->otherPekebun->id,
            'jenis_aktivitas' => 'Agenda Rahasia',
            'tanggal'         => now(),
            'status'          => 'pending',
        ]);

        $otherBiaya = BiayaOperasional::create([
            'user_id'     => $this->otherPekebun->id,
            'jenis_biaya' => 'Gaji Rahasia',
            'jumlah'      => 1000000,
            'tanggal'     => now(),
        ]);

        $otherPanen = HasilPanen::create([
            'user_id'       => $this->otherPekebun->id,
            'varietas'      => 'Super Tembaga',
            'jumlah_kg'     => 50,
            'tanggal_panen' => now(),
        ]);

        // Attempt edit & delete with 403 response
        $this->actingAs($this->pekebun)->get(route('portal.manajemen.lahan.edit', $otherLahan))->assertStatus(403);
        $this->actingAs($this->pekebun)->delete(route('portal.manajemen.lahan.destroy', $otherLahan))->assertStatus(403);

        $this->actingAs($this->pekebun)->get(route('portal.manajemen.jadwal.edit', $otherJadwal))->assertStatus(403);
        $this->actingAs($this->pekebun)->delete(route('portal.manajemen.jadwal.destroy', $otherJadwal))->assertStatus(403);

        $this->actingAs($this->pekebun)->get(route('portal.manajemen.biaya.edit', $otherBiaya))->assertStatus(403);
        $this->actingAs($this->pekebun)->delete(route('portal.manajemen.biaya.destroy', $otherBiaya))->assertStatus(403);

        $this->actingAs($this->pekebun)->get(route('portal.manajemen.panen.edit', $otherPanen))->assertStatus(403);
        $this->actingAs($this->pekebun)->delete(route('portal.manajemen.panen.destroy', $otherPanen))->assertStatus(403);
    }

    public function test_bibit_single_tag_input_defaults_to_one_and_dropdowns_render()
    {
        // 1. Test bibit create page renders dropdown options
        $createPage = $this->actingAs($this->pekebun)->get(route('portal.pembibitan.bibit.create'));
        $createPage->assertStatus(200);
        $createPage->assertSee('Musang King (D197)');
        $createPage->assertSee('Duri Hitam / Ochee (D200)');
        $createPage->assertSee('Okulasi Mata Tempel Bersertifikat');

        // 2. Test bibit can be stored without passing 'jumlah' (1 tag = 1 bibit individual)
        $response = $this->actingAs($this->pekebun)->post(route('portal.pembibitan.bibit.store'), [
            'kode_bibit'    => 'BBT-SINGLE-001',
            'nama_varietas' => 'Musang King (D197)',
            'asal_benih'    => 'Okulasi Mata Tempel Bersertifikat',
            'status'        => 'siap_tanam',
            'kondisi'       => 'sehat',
            'tanggal_semai' => now()->format('Y-m-d'),
        ]);
        $response->assertRedirect(route('portal.pembibitan.bibit.index'));

        $this->assertDatabaseHas('bibit', [
            'user_id'       => $this->pekebun->id,
            'kode_bibit'    => 'BBT-SINGLE-001',
            'nama_varietas' => 'Musang King (D197)',
            'jumlah'        => 1, // Otomatis bernilai 1
        ]);
    }
}
