<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FileDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download';

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
        $totalSize = 10;
        $this->info('Begin to download file');
        $this->output->progressStart($totalSize); // 告诉 laravel 我们需要处理的总数，也可以理解为需要把进度条拆分的单元数
        for($i = 0; $i < $totalSize; $i ++) {
            sleep(1);
            $this->output->progressAdvance(); // 每处理一个单元，就执行这个命令，让进度条前进
        }
        $this->output->progressFinish(); // 告诉 laravel 已处理完毕
        $this->info('Completed');
    }
}
