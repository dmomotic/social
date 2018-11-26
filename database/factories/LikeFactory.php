<?php

use Faker\Generator as Faker;
use App\User;
use App\Models\Status;

$factory->define(App\Models\Like::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create();
        },
        'status_id' => function(){
            return factory(Status::class)->create();
        }
    ];
});
