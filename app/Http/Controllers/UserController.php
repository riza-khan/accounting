<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show (){
        $users = User::all();
        return view('users', ['users' => $users]);
    }
}
