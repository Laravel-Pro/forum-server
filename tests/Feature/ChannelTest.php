<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Channel;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_browser_all_channels()
    {
        $channel = factory(Channel::class)->create();
        factory(Channel::class)->create();

        $response = $this->getJson('api/channels');

        $response->assertSee($channel->name)
            ->assertSee($channel->slug);

        $this->assertCount(2, $response->json());
    }
}
