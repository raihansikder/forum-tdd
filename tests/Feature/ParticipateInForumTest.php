<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations; // This will migrate all database and finally undo/rollback all migrations // This will migrate all database and finally undo/rollback all migrations

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);

        // and an existing thread
        $this->post('/threads/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->be($user = factory(User::class)->create());

        // and an existing thread
        $thread = factory(Thread::class)->create();

        // When the user adds a reply to the thread
        $reply = factory(Reply::class)->make();

        // Then their reply should be visible to the page
        $this->post(route('threads.show',$thread->id) . "/replies", $reply->toArray());

        $this->get(route('threads.show',$thread->id))
            ->assertSee($reply->body);

    }
}
