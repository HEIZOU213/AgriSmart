<?php

use App\Models\User;
use App\Models\Withdrawal;

test('admin can access admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertOk();
});

test('pekebun can access portal index', function () {
    $pekebun = User::factory()->create(['role' => 'pekebun']);

    $response = $this->actingAs($pekebun)->get('/portal');

    $response->assertOk();
});

test('user cannot access admin dashboard or portal', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    $this->actingAs($user)->get('/portal')->assertForbidden();
});

test('legacy roles petani and konsumen are normalized automatically', function () {
    $userPetani = User::factory()->create(['role' => 'petani']);
    $userKonsumen = User::factory()->create(['role' => 'konsumen']);

    expect($userPetani->role)->toBe('pekebun');
    expect($userKonsumen->role)->toBe('user');
});

test('admin approving withdrawal keeps held saldo and does not double deduct', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    // Pekebun balance after request was submitted (e.g. initial 500k, requested 150k, remaining 350k)
    $pekebun = User::factory()->create(['role' => 'pekebun', 'saldo' => 350000]);

    $withdraw = Withdrawal::create([
        'user_id' => $pekebun->id,
        'jumlah' => 150000,
        'status' => 'pending',
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
    ]);

    $response = $this->actingAs($admin)->patch("/admin/withdraw/{$withdraw->id}/approve");

    $response->assertSessionHas('success');
    $withdraw->refresh();
    $pekebun->refresh();

    expect($withdraw->status)->toBe('approved');
    // Saldo must remain 350000, not double-deducted to 200000
    expect((int) $pekebun->saldo)->toBe(350000);
});

test('admin rejecting withdrawal refunds saldo back to pekebun', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $pekebun = User::factory()->create(['role' => 'pekebun', 'saldo' => 350000]);

    $withdraw = Withdrawal::create([
        'user_id' => $pekebun->id,
        'jumlah' => 150000,
        'status' => 'pending',
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
    ]);

    $response = $this->actingAs($admin)->patch("/admin/withdraw/{$withdraw->id}/reject");

    $response->assertSessionHas('success');
    $withdraw->refresh();
    $pekebun->refresh();

    expect($withdraw->status)->toBe('rejected');
    // Saldo is refunded back: 350000 + 150000 = 500000
    expect((int) $pekebun->saldo)->toBe(500000);
});
