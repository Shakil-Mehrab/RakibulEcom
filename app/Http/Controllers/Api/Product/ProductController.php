<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view(){
        $products=Product::get();
        $items = \Cart::getContent();
        return view('welcome',compact('products','items'));
    }
    public function show($id){
        $product=Product::findOrFail($id);
        $items = \Cart::getContent();
        return view('layout.product.show',compact('product','items'));
    }
}
