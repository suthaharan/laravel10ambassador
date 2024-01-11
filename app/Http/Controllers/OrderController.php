<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    public function index(){
        //return Order::all();
        return OrderResource::collection((Order::all()));
    }

    public function withOrderItems(){
        //to make order items optional
        return OrderResource::collection(Order::with('orderItems')->get());
    }

}
