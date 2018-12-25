<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WelcomNewUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:newusers
                            {userId : The ID of the user}
                            {--sendEmail=: Whether to send user an email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $userId = $this->argument('userId');
        $sendEmail = $this->option('sendEmail');

        echo '新用户 ID 为:'.$userId.PHP_EOL;
        if ($sendEmail) {
            echo '给用户发送邮件'.PHP_EOL;
        }
    }
}
