<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function saveOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'total' => 'required|numeric'
        ]);

        $order = Order::create([
            'total' => $request->total
        ]);

        foreach ($request->order as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['total']
            ]);
        }

        return response()->json(['success' => true]);
    }
}