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

test('obsolete admin withdraw and product management routes return 404 not found', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->get('/admin/withdraw')->assertNotFound();
    $this->actingAs($admin)->get('/admin/products')->assertNotFound();
});
