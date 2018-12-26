<?php
/**
 * Created by PhpStorm.
 * User: linzhen
 * Date: 2018/12/26
 * Time: 13:14
 */
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class,20)->create();
    }
}