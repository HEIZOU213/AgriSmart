<?php

use App\Models\Bibit;
use App\Models\HasilPanen;
use App\Models\Lahan;
use App\Models\PohonDurian;
use App\Models\User;

test('full interconnected lifecycle: pembibitan -> pertumbuhan -> panen', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    // 1. Pekebun has a land
    $lahan = Lahan::create([
        'user_id'      => $pekebun->id,
        'nama_lahan'   => 'Lahan Bukit Mas',
        'lokasi'       => 'Zona Lereng A',
        'luas_ha'      => 3.0,
        'jumlah_pohon' => 0,
        'kondisi'      => 'baik',
    ]);

    // 2. Pekebun inputs seedling in Pembibitan with status siap_tanam
    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-MK-01',
        'nama_varietas' => 'Musang King Super',
        'asal_benih'    => 'Indukan Unggul Nasional',
        'jumlah'        => 3,
        'status'        => 'siap_tanam',
        'kondisi'       => 'sehat',
        'tanggal_semai' => now()->subMonths(8),
    ]);

    // Bibit is initially visible in pembibitan active index
    $resBibitIndex = $this->actingAs($pekebun)->get(route('portal.pembibitan.bibit.index'));
    $resBibitIndex->assertOk()->assertSee('Musang King Super')->assertSee('3 bibit');

    // 3. Pekebun accesses Pertumbuhan + Tambah Pohon
    $resPohonCreate = $this->actingAs($pekebun)->get(route('portal.pertumbuhan.pohon.create'));
    $resPohonCreate->assertOk()
        ->assertSee('Musang King Super')
        ->assertSee('Lahan Bukit Mas');

    // 4. Pekebun plants 2 trees from this bibit via Pertumbuhan
    $resTanam = $this->actingAs($pekebun)->post(route('portal.pertumbuhan.pohon.store'), [
        'bibit_id'      => $bibit->id,
        'lahan_id'      => $lahan->id,
        'jumlah'        => 2,
        'tanggal_tanam' => now()->format('Y-m-d'),
        'lokasi'        => 'Baris 1 Pohon 1-2',
        'catatan'       => 'Ditanam dengan pupuk organik dasar',
    ]);

    $resTanam->assertRedirect(route('portal.pertumbuhan.pohon.index'));
    $resTanam->assertSessionHas('success');

    // Check that 2 trees were created in Pertumbuhan, linked to bibit and lahan
    $pohonCount = PohonDurian::where('user_id', $pekebun->id)
        ->where('bibit_id', $bibit->id)
        ->where('lahan_id', $lahan->id)
        ->count();
    expect($pohonCount)->toBe(2);

    // Lahan tree counter incremented
    expect($lahan->fresh()->jumlah_pohon)->toBe(2);

    // Bibit remaining count is 1, status still siap_tanam
    $bibit->refresh();
    expect($bibit->jumlah)->toBe(1);
    expect($bibit->status)->toBe('siap_tanam');

    // 5. Pekebun plants the remaining 1 bibit
    $resTanamRemaining = $this->actingAs($pekebun)->post(route('portal.pertumbuhan.pohon.store'), [
        'bibit_id'      => $bibit->id,
        'lahan_id'      => $lahan->id,
        'jumlah'        => 1,
        'tanggal_tanam' => now()->format('Y-m-d'),
        'lokasi'        => 'Baris 1 Pohon 3',
    ]);

    $resTanamRemaining->assertRedirect(route('portal.pertumbuhan.pohon.index'));

    // Check all 3 trees created
    expect(PohonDurian::where('user_id', $pekebun->id)->count())->toBe(3);
    expect($lahan->fresh()->jumlah_pohon)->toBe(3);

    // Bibit count is now 0 and status changed to 'ditanam'
    $bibit->refresh();
    expect($bibit->jumlah)->toBe(0);
    expect($bibit->status)->toBe('ditanam');

    // 6. CRITICAL VERIFICATION: Bibit has "disappeared" from Pembibitan active index
    $resBibitActive = $this->actingAs($pekebun)->get(route('portal.pembibitan.bibit.index'));
    $resBibitActive->assertOk()->assertDontSee('3 bibit');

    // But can still be viewed under historical 'ditanam' filter tab
    $resBibitHistory = $this->actingAs($pekebun)->get(route('portal.pembibitan.bibit.index', ['status' => 'ditanam']));
    $resBibitHistory->assertOk()->assertSee('Musang King Super')->assertSee('Sudah Ditanam');

    // 7. Modul Pertumbuhan to Panen: Tree reaches productive phase and is harvested
    $pohon = PohonDurian::where('user_id', $pekebun->id)->first();
    $pohon->update(['fase' => 'produktif']);

    // Panen create form lists this productive tree
    $resPanenForm = $this->actingAs($pekebun)->get(route('portal.manajemen.panen.create'));
    $resPanenForm->assertOk()->assertSee($pohon->kode_pohon)->assertSee('Musang King Super');

    // Log harvest linked to this tree
    $resPanen = $this->actingAs($pekebun)->post(route('portal.manajemen.panen.store'), [
        'pohon_id'      => $pohon->id,
        'lahan_id'      => $lahan->id,
        'varietas'      => $pohon->nama_varietas,
        'jumlah_kg'     => 75.5,
        'harga_per_kg'  => 180000,
        'tanggal_panen' => now()->format('Y-m-d'),
        'catatan'       => 'Panen perdana grade A premium',
    ]);

    $resPanen->assertRedirect(route('portal.manajemen.panen.index'));

    $this->assertDatabaseHas('hasil_panen', [
        'user_id'      => $pekebun->id,
        'pohon_id'     => $pohon->id,
        'lahan_id'     => $lahan->id,
        'varietas'     => 'Musang King Super',
        'jumlah_kg'    => 75.5,
        'harga_per_kg' => 180000,
    ]);

    $harvest = HasilPanen::where('pohon_id', $pohon->id)->first();
    expect($harvest->pohon->id)->toBe($pohon->id);
    expect($harvest->pohon->bibit->id)->toBe($bibit->id);

    // Panen index displays tree info and market sell link
    $resPanenIndex = $this->actingAs($pekebun)->get(route('portal.manajemen.panen.index'));
    $resPanenIndex->assertOk()
        ->assertSee($pohon->kode_pohon)
        ->assertSee('Musang King Super')
        ->assertSee('Jual di Toko');
});

test('pohon cannot be planted more than available bibit stock', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);
    $lahan = Lahan::create([
        'user_id'      => $pekebun->id,
        'nama_lahan'   => 'Lahan Lembah',
        'luas_ha'      => 1.0,
        'jumlah_pohon' => 0,
        'kondisi'      => 'baik',
    ]);

    $bibit = Bibit::create([
        'user_id'       => $pekebun->id,
        'kode_bibit'    => 'BBT-LMT',
        'nama_varietas' => 'Duri Hitam',
        'jumlah'        => 2,
        'status'        => 'siap_tanam',
        'kondisi'       => 'sehat',
    ]);

    // Attempt to plant 5 when only 2 available
    $response = $this->actingAs($pekebun)->post(route('portal.pertumbuhan.pohon.store'), [
        'bibit_id'      => $bibit->id,
        'lahan_id'      => $lahan->id,
        'jumlah'        => 5,
        'tanggal_tanam' => now()->format('Y-m-d'),
    ]);

    $response->assertSessionHasErrors('jumlah');
    expect(PohonDurian::where('user_id', $pekebun->id)->count())->toBe(0);
    expect($bibit->fresh()->jumlah)->toBe(2);
});
