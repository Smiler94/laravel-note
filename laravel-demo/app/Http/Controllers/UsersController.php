<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    //
//    public function export()
//    {
//        return Excel::download(new UserExport(), 'users.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
//    }
    public function export(Excel $excel)
    {
//        return $excel::download(new UserExport(), 'users.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        return Excel::store(new UserExport(), 'users.xlsx', 's3');
    }
    public function import(Request $request)
    {
        Excel::import(new UserImport, $request->file('file'));

        return 'success';
    }
}
