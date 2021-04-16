<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function view()
    {
      $products=Category::orderBy('id','desc')->paginate(2);
      $columns=Category::columns();
      // return $products;
      return view('layouts.product.view',compact('products','columns'));
    }
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
      return redirect('admin/view/product');
  
    }
    public function edit($slug)
    {
      $product=Product::where('slug',$slug)->firstOrFail();
      return view('layouts.product.edit',compact('product'));
    }
    public function update(ProductUpdateRequest $request,$slug)
    {
      // dd($id);
      $product =Product::where('slug',$slug)->firstOrFail();
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
      
      $product->update();
      return back();
  
    }
    public function delete($slug){
      $product=Product::where('slug',$slug)->firstOrFail();
      $product->delete();
      return back();
    }
    public function search($slug){
      $products=Product::where('name','LIKE',"%".$slug."%")->paginate(2);
      // dd($products);
      $columns=Product::columns();
      // return response()->json(['products'=>$products,'columns'=>$columns],200);
      return view('layouts.product.table',compact('products','columns'));
    }
  }