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
// TEST NOT WORKING CHECK AFTER
//    /** @test */
//    function unauthenticated_users_may_not_add_replies()
//    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');
//        $this->post('/threads/1/replies', []);
//    }

//    /** @test */
//    function an_authenticated_user_may_participate_in_forum_threads()
//    {
//        $this->be($user = factory(User::class)->create()); //auth user
//
//        $thread = factory(Thread::class)->create();
//        //dd($thread);
//        $reply = factory(Reply::class)->create();
//        //dd($reply);
//        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
//        dd(  $this->post('/threads/' . $thread->id . '/replies', $reply->toArray()));
//        $this->get($thread->path())->assertSee($reply->body);
//    }
}
