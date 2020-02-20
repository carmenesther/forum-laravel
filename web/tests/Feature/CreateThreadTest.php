<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    function guests_may_not_create_threads ()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();
        // given a signed user
        $this->signIn();
        // create a new thread
        $response = $this->post('/threads', $this->thread->toArray());
        // when we visit the thread page, we should see the new one
        $this->get($response->headers->get('Location'))
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }
    /** @test */
    function a_thread_requires_a_title ()
    {
        $this->publishThread(['title' => null]);

    }

    /** @test */
    function a_thread_requires_a_body ()
    {

        $this->publishThread(['body' => null]);
    }

    /** @test */
    function a_thread_requires_a_valid_channel ()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null]);

        $this->publishThread(['channel_id' => 999]);
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, @$overrides);

        $this->post('/threads', $thread->toArray())->assertSessionHasErrors();
    }
}
