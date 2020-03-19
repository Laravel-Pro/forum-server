<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_thread_may_has_replies()
    {
        $this->disableExceptionHandling();

        $thread = factory(Thread::class)->create();

        $replies = factory(Reply::class, 1)->create([
            'thread_id' => $thread->id,
        ]);

        $replies->load(['owner:id,name,username,avatar']);

        $this->getJson("/api/threads/{$thread->id}")
            ->assertJsonPath('data.replies', $replies->toArray())
            ->assertJsonPath('data.replies.0.owner', $replies->first()->owner->toArray());
    }

    /** @test */
    public function an_authenticated_user_may_reply_threads()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();
        $this->be($user);

        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();

        $this->postJson("/api/threads/{$thread->id}/replies", $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->replies()->count());
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class, ['body' => null])->make();

        $this->postJson("/api/threads/{$thread->id}/replies", $reply->toArray())
            ->assertJsonValidationErrors('body');
    }
}
