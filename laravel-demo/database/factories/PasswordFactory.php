<?php
use Faker\Generator as Faker;

$factory->define(Password::class, function (Faker $faker) {
    return [
        'name' => 'test',
        'account' => 'test',
        'url' => 'test',
        'type' => 1,
        'password' => 'test',
        'remark' => 'test'
    ];
});