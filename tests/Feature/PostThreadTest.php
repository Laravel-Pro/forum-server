<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use DavidBadura\FakerMarkdownGenerator\FakerProvider as MarkdownFakerProvider;
use Illuminate\Support\Arr;
use Tests\TestCase;

class PostThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker->addProvider(new MarkdownFakerProvider($this->faker));
    }

    /** @test */
    public function an_auth_user_can_post_thread()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $threadData = $this->createThreadData();

        $response = $this->postJson('/api/threads', $threadData);
        $response->assertSuccessful();
        $this->assertDatabaseHas('threads', $threadData);
    }

    /** @test */
    public function a_guest_cannot_post_thread()
    {
        $threadData = $this->createThreadData();

        $response = $this->postJson('/api/threads', $threadData);
        $response->assertUnauthorized();
    }

    /** @test */
    public function post_thread_require_title()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $threadData = $this->createThreadData();

        $response = $this->postJson('/api/threads', Arr::only($threadData, ['channel_id', 'body']));
        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function post_thread_require_body()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $threadData = $this->createThreadData();

        $response = $this->postJson('/api/threads', Arr::only($threadData, ['channel_id', 'title']));
        $response->assertJsonValidationErrors(['body']);
    }

    /** @test */
    public function post_thread_require_channel()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $threadData = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->markdown,
        ];

        $response = $this->postJson('/api/threads', $threadData);
        $response->assertJsonValidationErrors(['channel_id']);
    }

    protected function createThreadData()
    {
        $channel = factory(Thread::class)->create();

        return [
            'channel_id' => $channel->id,
            'title' => $this->faker->sentence,
            'body' => $this->faker->markdown,
        ];
    }
}
