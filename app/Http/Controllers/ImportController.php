<?php

namespace App\Http\Controllers;

use App\Imports\CarsImport;
use App\Imports\InvoiceImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('file')->store('import');

        (new UsersImport)->import($file);
        return back()->withStatus('Excel file imported successfully');
    }

    /**
     * Importing car data from excel file
     *
     * @return void
     */
    public function cars(Request $request):Response
    {
        $file = $request->file('file')->store('import');

        (new CarsImport)->import($file);
        return response('File successfully imported', 200);
    }

    public function invoices(Request $request):Response
    {
        $file = $request->file('file')->store('import');

        (new InvoiceImport)->import($file);
        return response('File successfully imported', 200);
    }

}
