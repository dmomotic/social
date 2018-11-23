<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function registered_users_can_login()
    {
        factory(User::class)->create(['email' => 'user@mail.com']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'user@mail.com')
                    ->type('password', 'secret')
                    ->press('#login-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated()        
            ;
        });
    }
}
