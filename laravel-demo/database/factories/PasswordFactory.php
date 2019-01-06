<?php
use Faker\Generator as Faker;

$factory->define(Password::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'account' => $faker->account(),
        'url' => 'test',
        'type' => 1,
        'password' => 'test',
        'remark' => 'test'
    ];
});