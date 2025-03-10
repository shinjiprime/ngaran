<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Make sure to import the User model

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class PageController extends Controller
{
    //
    public function loadHome(){
        
            $users = User::all(); // Retrieve all users
            return view('adminpages.users', compact('users')); // Adjust the view name as necessary
        
    }
     public function loadMaster(){
        return view('master');
    }
}
