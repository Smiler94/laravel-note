<?php

namespace App\Http\Controllers;

use App\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $passwords = Password::all();
        $password = DB::select('select * from password');
        
        return $password;
        // return $passwords->toJson();
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
        // $password = DB::select('select * from password where id = ?', [$id]);
        $password = DB::table('password')->where('id', $id)->get();

        return $password;
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

    public function test()
    {
        DB::connection()->enableQueryLog();
        // $password = DB::table('password')->whereBetween('id', [5,10])->get();
        // $password = DB::table('password')->whereNull('name')->get();
        // $password = DB::table('password')->whereIn('id', [1,2])->whereRaw('type = 2')->get();
        // $password = DB::table('password')->select('type,name')->distinct()->get();
        // $password = DB::table('password')->groupBy('type')->havingRaw('count(id) > 10')->get();
        // $password = DB::table('password')->skip(10)->take(10)->get();
        $password = DB::table('password')->latest('id')->get();
        
        $query = DB::getQueryLog();
        print_r($query);

        print_r($password);
        // return $password;
    }
}
