<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //

    
    public function store (Request $request) {
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id|distinct',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        return DB::transaction(function () use ($request) {
            $total = 0;
            $syncData = [];

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $total += $product->price * $item['quantity'];
                $syncData[$item['product_id']] = ['quantity' => $item['quantity']];
            }

            $order = Order::create([
                'user_id' => $request->user_id,
                'total' => $total
            ]);

            $order->products()->attach($syncData);

            return response()->json($order->load('products'), 201);
        });
    }

    public function productsOrder (Order $order) {
        return response()->json([
            'id' => $order->id,
            'user' => $order->user,
            'products' => $order->products()->withPivot('quantity')->get(),
            'total' => $order->total
        ]);
    }

}
