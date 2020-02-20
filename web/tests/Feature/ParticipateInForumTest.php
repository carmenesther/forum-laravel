<?php

namespace Tests\Feature;

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
        $this->post('/threads/1/replies', []);
        $this->withoutExceptionHandling();
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class);

        $reply = create(Reply::class);

        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);

    }
}
