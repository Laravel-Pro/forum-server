<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_channel_list()
    {
        $channels = factory(Thread::class, 1)->create();

        $response = $this->getJson('/api/threads');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'author' => ['id', 'name', 'username'],
                    'channel' => ['id', 'name', 'slug'],
                    'title',
                    'replies_count',
                    'activity_at',
                    'updated_at',
                    'created_at',
                ]],
                'links',
                'meta',
            ])
            ->assertJson(['data' => $channels->makeHidden('rendered')->toArray()]);
    }
}
