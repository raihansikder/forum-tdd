<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{

    use DatabaseMigrations; // This will migrate all database and finally undo/rollback all migrations

    /** @test */
    public function guest_may_not_create_thread()
    {
        $this->expectException(AuthenticationException::class);
        // When guest hit the endpoint to create thread
        /** @var Thread $thread */

        // $thread = factory(Thread::class)->make(); // Using the new helper make() in the next line.
        $thread = make(Thread::class);
        $this->post(route('threads.store'), $thread->toArray());
    }

    /** @test */
    public function guest_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_create_new_thread()
    {
        // Given we have a signed in user
        $this->signIn();

        // When we hit the endpoint to create thread
        /** @var Thread $thread */
        $thread = factory(Thread::class)->make();
        $this->post(route('threads.store'), $thread->toArray());

        // Then when we visit the thread page
        // We should see the new thread
        $this->get(route('threads.index'))->assertSee($thread->title);
    }
}
