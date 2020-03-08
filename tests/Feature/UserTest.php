<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_get_self_info()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $userInfo = $this->getJson('/api/user/self');
        $userInfo->assertJson($user->toArray());
    }
}
