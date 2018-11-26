<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Models\Status;

class CanLikeStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_like_statuses()
    {
        $this->withOutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->actingAs($user)->postJson(route('statuses.like.store', $status));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ]);
    }

    /** @test */
    public function guest_users_can_not_like_statuses()
    {
        $status = factory(Status::class)->create();
        $response = $this->post(route('statuses.like.store', $status));
        $response->assertRedirect('login'); //Para que pase agregar middleware auth en ruta
    }
    
}
