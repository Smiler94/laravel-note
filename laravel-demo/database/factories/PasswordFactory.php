<?php
use Faker\Generator as Faker;

$factory->define(App\Password::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'account' => $faker->text(),
        'url' => $faker->url(),
        'type' => 1,
        'password' => 'test',
        'remark' => $faker->text()
    ];
});