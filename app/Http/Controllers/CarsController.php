<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Return all model data using pagination
     *
     * @return void
     */
    public function index()
    {
        return Car::paginate(15);
    }


}
