<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_cannot_create_thread()
    {
        $this->withExceptionHandling();
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function guests_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }
    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();
        // given a signed user
        $this->signIn();
        // create a new thread
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());
        // when we visit the thread page, we should see the new one
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
