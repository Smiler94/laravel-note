<?php
/**
 * Created by PhpStorm.
 * User: linzhen
 * Date: 18/12/22
 * Time: 下午10:34
 */

namespace App\Http\Controllers;

use \Illuminate\Http\Request;

class FileController
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            var_dump($request->file('file'));
        }
    }
}