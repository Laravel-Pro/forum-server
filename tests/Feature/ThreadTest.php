<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_channel_list()
    {
        $thread = factory(Thread::class, 2)->create();

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
            ->assertJson(['data' => $thread->makeHidden('body')->toArray()]);
    }

    /** @test */
    public function thread_can_be_filtered_by_channel()
    {
        $theChannel = factory(Channel::class)->create();
        $otherChannel = factory(Channel::class)->create();

        $thread = factory(Thread::class)->create(['channel_id' => $theChannel->id]);
        $threadNotInTheChannel = factory(Thread::class)->create(['channel_id' => $otherChannel->id]);

        $response = $this->getJson('/api/threads?channel=' . $theChannel->slug);

        $response->assertSee($thread->title)
            ->assertDontSee($threadNotInTheChannel->title);
    }
}
