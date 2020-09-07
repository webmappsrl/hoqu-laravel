<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Queue::class, function (Faker $faker) {
    return [
        'instance' => $faker->sentence(20),
        'task' => $faker->sentence(30),
        'parameters' => $faker->sentence(40),
    ];
});
