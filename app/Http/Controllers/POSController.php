<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $order = session()->get('order', []);
        $total = array_sum(array_column($order, 'total_price'));
        return view('pos.index', compact('products', 'order', 'total'));
    }

    public function addToOrder(Request $request)
    {
        $product = Product::find($request->product_id);
        $order = session()->post('order', []);

        if(isset($order[$product->id])) {
            $order[$product->id]['quantity'] += 1;
            $order[$product->id]['total_price'] += $product->price;
        } else {
            $order[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'total_price' => $product->price
            ];
        }

        session()->put('order', $order);

        return response()->json(['order' => $order, 'total' => array_sum(array_column($order, 'total_price'))]);
    }

    public function saveOrder(Request $request)
    {
        $order = session()->get('order', []);

        foreach($order as $item) {
            Order::create([
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price']
            ]);
        }
    
        session()->forget('order');
    
        return response()->json(['message' => 'Order saved successfully!']);
    }

    public function printOrder(Request $request)
    {
        $order = session()->get('order', []);
    
    $this->saveOrder($request);

    return view('pos.print', compact('order'));
    }

    public function chargeOrder(Request $request)
    {
        $total = $request->total;
        $payment = $request->payment;
        $change = $payment - $total;
    
        if ($change < 0) {
            return response()->json(['message' => 'Insufficient payment!']);
        }
    
        $this->saveOrder($request);
    
        session()->forget('order');
    
        return response()->json([
            'message' => 'Payment successful!',
            'total' => $total,
            'payment' => $payment,
            'change' => $change
        ]);
        }
}
