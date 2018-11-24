<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    //Ejecutamos migraciones ya que nuestra base de datos para pruebas se carga en memoria
    use RefreshDatabase; 

    /** @test */
    public function guests_users_can_not_create_statuses()
    {
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer status']);

        $response->assertRedirect('login');
    }

    /** @test **/
    public function an_authenticated_user_can_create_statuses()
    {
        //Para evitar que laravel maneje las excepciones. Utilizado para un mejor detalle del fallo de la prueba,
        $this->withoutExceptionHandling();

        //1.Given => Teniendo un usuario autenticado
        $user = factory(User::class)->create();
        $this->actingAs($user);

        //2.When => Cuando hace un post request a status
        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);
        $response->assertJSON([
            'data' => ['body' => 'Mi primer status']
        ]);

        //3.Then => Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer status'
        ]);
    }

    /** @test */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422); //Entidad no procesable

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** @test */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

        $response->assertStatus(422); //Entidad no procesable

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
    
}
