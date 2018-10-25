<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use URL;

class CreateThreadTest extends TestCase
{

    use DatabaseMigrations; // This will migrate all database and finally undo/rollback all migrations

    /** @test */
    public function guest_may_not_create_thread()
    {

        /*
         * As a guest when we attempt to access a route that requires authentication we hit this
         * exception Illuminate\Auth\AuthenticationException and our test fails.
         * But hitting this exception is perfectly fine and expected.
         * So this line $this->withExceptionHandling() allow that exception to occur but
         * still proceed with the tests.
         */
        $this->withExceptionHandling();
        /*************************************/

        // When a guest tries to access the 'threads.create' route he should be redirected to login.
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));

        // When a guest tries to POST in 'threads.store' route he should be redirected to login.
        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));

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
        $thread = create(Thread::class);

        //$response = $this->post(route('threads.store'), $thread->toArray());
        //dd($response);

        // Then when we visit the thread page
        // We should see the new thread

        $this->get(route('threads.show', [$thread->channel_id, $thread->id]))->assertSee($thread->title);
    }
}
