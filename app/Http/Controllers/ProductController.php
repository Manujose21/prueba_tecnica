<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function indexView() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    public function index() {
        $products = Product::all();

        return response()->json($products);
    }


    public function store(Request $request) {

        $request->validate(['name' => 'required', 'price' => 'required|numeric|min:0.01']);

        $product = Product::create($request->all());

        return response()->json(["product" => $product]);
    }


}
