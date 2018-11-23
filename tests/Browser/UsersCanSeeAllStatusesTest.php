<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Status;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_all_statuses_on_the_homepage()
    {
        $statuses = factory(Status::class,3)->create();
        $this->browse(function (Browser $browser) use ($statuses) {
            $browser->visit('/')
                    ->waitForText($statuses->first()->body)
                    ->assertSee($statuses->first()->body)        
            ;
            foreach ($statuses as $status) {
               $browser->assertSee($status->body);
            }
        });
    }
}