<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Bahraminekoo\Employee\Models\Employee;
use Faker\Generator as Faker;

/**
 * model factory to create dummy employees for seeding or testing purposes
 */
$factory->define(Employee::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween('-100 days', '+100 days');
    $date = $date->format('Y-m-d');
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'doe' => $date,
    ];
});
