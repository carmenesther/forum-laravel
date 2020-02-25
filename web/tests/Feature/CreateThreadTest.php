<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
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

    /** @test */
    function unauthorized_user_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

//        $this->assertDatabaseMissing('activities', [
//            'subject_id' => $reply->id,
//            'subject_type' => get_class($reply)
//        ]);
//
//        $this->assertDatabaseMissing('activities', [
//           'subject_id' => $thread->id,
//           'subject_type' => get_class($thread)
//        ]);

        $this->assertEquals(0, Activity::count());
    }

    /** @test*/
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, @$overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
