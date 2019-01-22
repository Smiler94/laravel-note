<?php
use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->text(),
        'email' => $faker->email(),
        'phone' => $faker->phoneNumber()
    ];
});