<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Queue::class, function (Faker $faker) {
    return [
        'instance' => $faker->sentence,
        'task' => $faker->paragraph,
        'parameters' => $faker->paragraph
    ];
});
