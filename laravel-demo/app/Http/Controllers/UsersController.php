<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    //
    public function export()
    {
        return Excel::download(new UserExport(), 'users.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new UserImport, $request->file('file'));

        return 'success';
    }
}
