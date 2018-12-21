<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        $all = $request->all();
//        var_dump($all);
//        $title = $all['title'];
//        $description = $all['description'];

//        $req = $request->except('_token');
//        $req = $request->except(['_token', 'title']);

//        $req = $request->only('title');
//        $req = $request->only(['title','description']);

//        if ($request->filled('title')) {
//            return 'title 存在且有值';
//        } elseif ($request->exists('title')) {
//            return 'title 存在但为空';
//        } else {
//            return 'title 不存在';
//        }

//        $title = $request->input('title');
//        $description = $request->input('description');

        $title = $request->json('title');
        $description = $request->json('description');
//        return $req;
        return "title is {$title}, description is {$description}";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
