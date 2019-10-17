<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;

class OrderController extends Controller
{
    public function index()
    {
        $order = Orders::all()->groupBy('transaction_code');
        return $order;

    }

    public function store(Request $request)
    {
        $orders = $request->orders;
        $order = Orders::insert($orders);

        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function order(Request $request)
    {
        $order = Orders::where('transaction_code',$request->order)->get();
        return $order;

    }
}
