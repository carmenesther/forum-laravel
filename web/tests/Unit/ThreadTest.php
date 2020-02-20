<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Collection|\Illuminate\Database\Eloquent\Model
     */
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

        /** @test */
            function a_thread_can_make_a_string_path ()
            {
                $this->withoutExceptionHandling();
                $thread = $this->thread;
                $this->assertEquals(
                    "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
            }
    /** @test */
    function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    function a_thread_has_a_creator(){
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    function a_thread_can_add_a_reply(){
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1,  $this->thread->replies);
    }

    /** @test */
    function a_thread_belongs_to_a_channel ()
    {
        $this->withoutExceptionHandling();

        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }
}
