<?php

namespace App\Http\Controllers;

use App\Imports\BillImport;
use App\Imports\InvoiceImport;
use App\Imports\CustomerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    public function invoices(Request $request): Response
    {
        $file = $request->file('file')->store('import');
        Excel::import(new InvoiceImport, $file);

        return response('File successfully imported', 200);
    }

    public function bills(Request $request): Response
    {
        $file = $request->file('file')->store('import');
        Excel::import(new BillImport, $file);

        return response('File successfully imported', 200);
    }

    public function customers(Request $request): Response
    {
        $file = $request->file('file')->store('import');
        Excel::import(new CustomerImport, $file);

        return response('File successfully imported', 200);
    }
}
