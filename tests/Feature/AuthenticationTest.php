<?php

use App\Models\User;

test('users can register and access the dashboard', function () {
    $response = $this->post(route('register'), [
        'name' => 'Kiaron',
        'email' => 'kiaron@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['email' => 'kiaron@example.com']);
});

test('users can log in and log out', function () {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);

    $this->post(route('logout'))->assertRedirect(route('login'));
    $this->assertGuest();
});
