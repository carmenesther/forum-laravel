<?php

namespace Tests\Feature;

use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->post('/threads/post/1/replies', []);
        $this->withoutExceptionHandling();
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    function a_reply_requires_a_body ()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors();
    }

    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
         $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth() -> id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

}
