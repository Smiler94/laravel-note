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
        // $password = DB::table('password')->latest('id')->get();
        // $password = DB::table('password')->inRandomOrder()->get();
        // $password = DB::table('password')->get(['name', 'url']);
        // $password = DB::table('password')->first(['name', 'url']);
        $password = DB::table('password')->find(1);
        
        // try {
        //     $password = \App\Password::findOrFail(100);
        // } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     dump($e);exit;
        // }
        
        // $password = DB::table('password')->value('url');
        // $password = DB::table('password')->count();
        // $password = DB::table('password')->min('id');
        
        // $password = $password = DB::table('password')
        //     ->join('user', 'user.id', '=', 'password.user_id')
        //     ->select('password.*', 'user.name as u_name', 'user.email as u_email')
        //     ->first();
        //     
        // $first = DB::table('password')->where('id', 1);
        // $password = DB::table('password')->union($first)->where('id', 2)->get();
        
        // $password = DB::table('password')->insert([
        //         'user_id' => 1,
        //         'name' => 'abcds',
        //         'account' => 'asdf',
        //         'url' => '',
        //         'type' => 1,
        //         'password' => '123123',
        //         'remark' => 'test'
        //     ]);
        
        // $password = DB::table('password')->insertGetId([
        //     'user_id' => 1,
        //     'name' => 'abcds',
        //     'account' => 'asdf',
        //     'url' => '',
        //     'type' => 1,
        //     'password' => '123123',
        //     'remark' => 'test'
        // ]);
        
        // $password = DB::table('password')->where('id', 30)->update(['attributes' => json_encode([
        //     'isAdmin' => true, 'isHome' => false])]);
        // $password = DB::table('password')->where('id', 32)->increment('type', 2);
        // $password = DB::table('password')->where('url', '')->delete();
        // $password = DB::table('password')->where('attributes->isAdmin', true)->get();
        // 
        // $query = DB::getQueryLog();
        // print_r($query);
        dump($password);
        // return $password;
    }
}
