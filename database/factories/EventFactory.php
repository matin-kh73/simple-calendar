<?php

/** @var Factory $factory */

use App\Models\Event;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'title' => $faker->title,
        'start_at' => now(),
        'end_at' => $faker->dateTimeBetween(now()->addDay(1), now()->addDay(3)),
        'description' => $faker->title,
        'status' => rand(0, 1),
    ];
});
