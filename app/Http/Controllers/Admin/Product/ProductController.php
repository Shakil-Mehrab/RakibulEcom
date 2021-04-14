<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductInputRequest;

class ProductController extends Controller
{
  public function create()
  {
    return view('layouts.product.create');
  }
  public function store(ProductInputRequest $request)
  {
    $product = new Product();
    $product->name = $request['name'];
    $product->slug = $request['slug'];
    $product->price = $request['price'];
    $product->brand = $request['brand'];
    $product->short_description = $request['short_description'];
    $product->description = $request['description'];
   
    $image=$request->file("image"); 
    if($image){
    $image_ext=$image->getClientOriginalExtension();
    $image_name=Str::random(10);
    $image_full_name=$image_name.".".$image_ext;

     $upload_path="images/product/";
     $image_url=$upload_path.$image_full_name;
     $success=$image->move($upload_path,$image_full_name);
    if($success){
      $product->thumbnail=$image_url;
    }
 }
    
    $request->user()->products()->save($product);
    dd('its ok');

  }
}
