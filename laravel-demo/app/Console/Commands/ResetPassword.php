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
            $this->error('Sorry, the password you entered is wrong');
        } else {
            $newPassword = $this->secret('Please enter the new password');

            $passwordConfirm = $this->secret('Please enter the new password again');

            if ($newPassword != $passwordConfirm) {
                $this->error('Sorry, the password you entered were different');
            } else {
                $headers = ['name', 'password'];
                $data = [
                    [$email, $oldPassword],
                    [$email, $newPassword]
                ];
                $this->comment("Hello, {$email}, your password has changed successfully");
                $this->table($headers, $data);
            }
        }
    }
}