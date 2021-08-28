<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        return Company::paginate(15);
    }

    public function create(Request $request)
    {
        $rules = [
            'realm' => ['required'],
            'name'  => ['required'],
        ];

        $company = Validated::make($request->all(), $rules);
    }
}
