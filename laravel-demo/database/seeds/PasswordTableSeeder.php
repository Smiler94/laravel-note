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
        DB::table('password')->insert([
            'name' => 'test',
            'account' => 'test',
            'url' => 'laravel.lz',
            'type' => 1,
            'password' => '12313212',
            'remark' => 'test'
        ]);
    }
}
