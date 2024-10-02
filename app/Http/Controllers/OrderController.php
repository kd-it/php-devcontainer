<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Orderdetail;
use App\Models\Cart;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // カート内の全ての商品を取り出す
        $carts = Cart::with('item')->get();

        // 注文テーブルに登録
        $order = new Order();
        $order->orderdate = date("Y-m-d H:i:s");
        $order->save();

        // 注文番号を取得する
        $last_insert_id = $order->orderId; //上記で登録したorderIdを取得
        foreach ($carts as $cart) {
            $orderdetail = new Orderdetail();
            $orderdetail->orderId = $last_insert_id;
            $orderdetail->itemId = $cart->ident;
            $orderdetail->quantity = $cart->quantity;
            $orderdetail->save();
        }

        // カート内のすべでの商品を削除する
        Cart::truncate();
        return view('order.index', ['carts' => $carts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
