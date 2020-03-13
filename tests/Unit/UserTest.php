<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_avatar_should_auto_complete()
    {
        $user = factory(User::class)->make([
            'avatar' => 'default-avatar.png',
        ]);

        $this->assertStringEndsWith('png', $user->avatar_url);
        $this->assertFileExists(storage_path('app') . $user->avatar_url);
    }
}
