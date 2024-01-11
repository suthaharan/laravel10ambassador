<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index($user_id){
        return Link::whereUserId($user_id)->get();
    }
}
