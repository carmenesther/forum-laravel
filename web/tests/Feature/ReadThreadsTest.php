<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void {

        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    /** @test
     */
    public function a_user_can_view_all_threads()
    {
       $this->get('/threads')->assertSee($this->thread->title);

    }
    /** @test */
    public function a_user_can_read_a_single_thread(){

        $this->get('/threads/' .$this->thread->id)->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread(){

        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' .$this->thread->id)->assertSee($reply->body);
    }
}
