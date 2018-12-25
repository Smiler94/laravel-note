<?php
/**
 * Created by PhpStorm.
 * User: linzhen
 * Date: 18/12/25
 * Time: 下午9:28
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;

class ResetPassword extends Command
{
    protected $signature = 'password:reset';

    protected $description = 'Reset your password';

    // 执行命令
    public function handle()
    {
        $email = $this->ask('What is your email address?');

        $oldPasswordConfirm = '123456';

        $oldPassword = $this->secret('What is your old password?');

        if ($oldPassword != $oldPasswordConfirm) {
            exit('Sorry, the password you entered is wrong'.PHP_EOL);
        } else {
            $newPassword = $this->secret('Please enter the new password');

            $passwordConfirm = $this->secret('Please enter the new password again');

            if ($newPassword != $passwordConfirm) {
                exit('Sorry, the password you entered were different'.PHP_EOL);
            } else {
                exit("Hello, {$email}, your password has changed successfully".PHP_EOL);
            }
        }
    }
}