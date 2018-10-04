<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{

    /** @test */
    public function guest_may_not_create_thread()
    {
        $this->expectException(AuthenticationException::class);
        // When guest hit the endpoint to create thread
        /** @var Thread $thread */
        $thread = factory(Thread::class)->make();
        $this->post(route('threads.store'), $thread->toArray());
    }

    /** @test */
    public function an_authenticated_user_can_create_new_thread()
    {
        // Given we have a signed in user
        $this->actingAs(factory(User::class)->create());

        // When we hit the endpoint to create thread
        /** @var Thread $thread */
        $thread = factory(Thread::class)->make();
        $this->post(route('threads.store'), $thread->toArray());

        // Then when we visit the thread page
        // We should see the new thread
        $this->get(route('threads.index'))->assertSee($thread->title);
    }
}
