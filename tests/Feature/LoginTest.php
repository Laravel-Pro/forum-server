<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_use_email_login()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/auth/login', [
            'loginAs' => $user->email,
            'password' => 'password',
        ]);

        $response->assertJson($user->toArray());

        $this->assertAuthenticated();
    }

    /** @test */
    public function a_guest_can_use_username_login()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/auth/login', [
            'loginAs' => $user->username,
            'password' => 'password',
        ]);

        $response->assertJson($user->toArray());

        $this->assertAuthenticated();
    }
}
