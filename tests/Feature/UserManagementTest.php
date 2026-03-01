<?php

use App\Enums\Role;
use App\Livewire\UserManagement;
use App\Models\User;
use Livewire\Livewire;

test('user management page is restricted to super admin', function () {
    $user = User::factory()->create(['role' => Role::Noc]);

    $this->actingAs($user)
        ->get(route('users.index'))
        ->assertForbidden();
});

test('super admin can access user management page', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk();
});

test('super admin can create a new user', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->set('name', 'New User')
        ->set('email', 'newuser@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('role', Role::Finance->value)
        ->call('createUser')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'email' => 'newuser@example.com',
        'role' => Role::Finance->value,
    ]);
});

test('super admin can update a user', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    $user = User::factory()->create(['role' => Role::Noc]);

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->call('editUser', $user->id)
        ->set('name', 'Updated Name')
        ->set('role', Role::Marketing->value)
        ->call('updateUser')
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->name)->toBe('Updated Name');
    expect($user->role)->toBe(Role::Marketing);
});

test('super admin can delete a user', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    $user = User::factory()->create(['role' => Role::Noc]);

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->call('confirmDelete', $user->id)
        ->call('deleteUser')
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('super admin cannot delete their own account', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->call('confirmDelete', $admin->id)
        ->call('deleteUser')
        ->assertHasErrors('delete');

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('user model has correct role helpers', function () {
    $admin = User::factory()->create(['role' => Role::SuperAdmin]);
    $noc = User::factory()->create(['role' => Role::Noc]);

    expect($admin->isSuperAdmin())->toBeTrue();
    expect($admin->hasRole(Role::SuperAdmin))->toBeTrue();
    expect($noc->isSuperAdmin())->toBeFalse();
    expect($noc->hasRole(Role::Noc))->toBeTrue();
});
