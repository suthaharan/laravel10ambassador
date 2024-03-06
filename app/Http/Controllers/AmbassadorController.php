<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AmbassadorController extends Controller
{
    public function index(){
        //return User::where('is_admin', 0)->get();
        //return User::whereIsAdmin(0)->get();

        // using local scope
        return User::ambassadors()->get();
    }
}
