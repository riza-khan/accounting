<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function show()
    {
        return view('users.imports');
    }

    public function store(Request $request)
    {
        $file = $request->file('file')->store('import');

        (new UsersImport)->import($file);
        return back()->withStatus('Excel file imported successfully');
    }
}
