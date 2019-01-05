<?php

use Illuminate\Database\Seeder;

class PasswordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $password = factory(Password::class);
        var_dump($password);
    }
}
