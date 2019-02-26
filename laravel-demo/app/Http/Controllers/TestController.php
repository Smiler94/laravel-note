<?php

namespace App\Http\Controllers;

use App\Jobs\LinzhenQueue;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test()
    {
//        LinzhenQueue::dispatch(['test'=>'test']);
        dump(app('queue')->connection('rabbitmq')->pushRaw(json_encode(['test'=>'test'])));
    }
}
