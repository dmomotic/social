<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Status;
use App\User;
use App\Models\Like;

class StatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_status_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();

        $this->assertInstanceOf(User::class, $status->user); 
    }

    /** @test */
    public function a_status_has_many_likes()
    {
        $status = factory(Status::class)->create();
        factory(Like::class)->create(['status_id' => $status->id]);

        $this->assertInstanceOf(Like::class, $status->likes->first());
    }

    /** @test */
    public function a_status_can_be_liked_and_unliked()
    {
        $status = factory(Status::class)->create();
        $this->actingAs(factory(User::class)->create());
        //Like a comentario
        $status->like();
        $this->assertEquals(1, $status->fresh()->likes->count());
        //Dislike a comentario
        $status->unlike();
        $this->assertEquals(0, $status->fresh()->likes->count()); //Fresh para no buscar en cache
    }
    
    /** @test */
    public function a_status_can_be_liked_once()
    {
        $status = factory(Status::class)->create();
        $this->actingAs(factory(User::class)->create());
        //Primer like
        $status->like();
        $this->assertEquals(1, $status->likes->count());
        //Segundo like
        $status->like();
        $this->assertEquals(1, $status->fresh()->likes->count()); //Usamos fresh porque la variable $status se almacena en cache y si no no actualiza bien el conteo.
    }
    
    /** @test */
    public function a_status_knows_if_it_has_been_liked()
    {
        //Al crear el estado no tiene likes
        $status = factory(Status::class)->create();
        $this->assertFalse($status->isLiked());
        //Damos like al estado
        $this->actingAs(factory(User::class)->create());
        $status->like();
        //Comprobamos que ahora tenga el like del usuario
        $this->assertTrue($status->isLiked());
    }
    
    /** @test */
    public function a_status_knows_how_many_likes_it_has()
    {
        $status = factory(Status::class)->create();
        $this->assertEquals(0, $status->likesCount());
        
        factory(Like::class, 2)->create(['status_id' => $status->id]);
        $this->assertEquals(2, $status->likesCount());
    }
    
}
