<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_can_register_with_email()
    {
        $faker = $this->faker;
        $user = [
            'username' => $faker->regexify('^[A-Za-z0-9][A-Za-z0-9_-]{3,39}$'),
            'email' => $faker->unique()->safeEmail,
            'password' => $faker->password(8, 100),
        ];

        $response = $this->postJson('api/auth/register', $user);

        $response->assertJson([
            'username' => $user['username'],
            'email' => $user['email'],
        ]);

        $this->assertDatabaseHas('users', $response->json());
    }

    /** @test */
    public function register_require_valid_data()
    {
        $user = [
            'username' => '_',
            'email' => 'invalid-email',
            'password' => 'short',
        ];

        $response = $this->postJson('api/auth/register', $user);

        $response->assertJsonValidationErrors(['username', 'email', 'password']);
    }
}
