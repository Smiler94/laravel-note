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
        // 创建一个实例
        $password = factory(App\Password::class, 10)->create();
    }
}
