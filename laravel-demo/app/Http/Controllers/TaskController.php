<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

class TaskController extends Controller
{
    //
    public function home()
    {
        return 'this is task home';
    }

//    public function store()
//    {
//        $title = Input::get('title');
//        $description = Input::get('description');
//
//        return "title is {$title}, description is {$description}";
//    }

    public function store(\Illuminate\Http\Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');

        return "title is {$title}, description is {$description}";
    }
}
