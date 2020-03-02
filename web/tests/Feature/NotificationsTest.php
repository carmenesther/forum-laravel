<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        // then each time a new reply is left

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }
}
