<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductInputRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
  public function view()
  {
    if (request('per-page')) {
      $datas = Product::orderBy('id', 'desc')
        ->pagination(request('per-page'));

      $columns = Product::columns();
      return view('layouts.table', compact('datas', 'columns'))->render();
    }
    if (request('page')) {
      $datas = Product::orderBy('id', 'desc')
      ->paginate(10);
      $columns = Product::columns();
      return view('layouts.table', compact('datas', 'columns'))->render();
    }

    $datas = Product::orderBy('id', 'desc')
      ->paginate(10);

    $columns = Product::columns();
    return view('layouts.product.view', compact('datas', 'columns'));
  }
  
  public function search()
  {
    $query = request('query');
    $datas = Product::where('name', 'LIKE', "%" . $query . "%")
      ->pagination(request('per-page'));
    $columns = Product::columns();
    return view('layouts.table', compact('datas', 'columns'));
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

    $image = $request->file("image");
    if ($image) {
      $image_ext = $image->getClientOriginalExtension();
      $image_name = Str::random(10);
      $image_full_name = $image_name . "." . $image_ext;

      $upload_path = "images/product/";
      $image_url = $upload_path . $image_full_name;
      $success = $image->move($upload_path, $image_full_name);
      if ($success) {
        $product->thumbnail = $image_url;
      }
    }

    $request->user()->products()->save($product);
    return redirect('admin/view/product')
      ->withSuccess('Product Created Successfully');
  }
  public function edit($slug)
  {
    $product = Product::where('slug', $slug)
      ->firstOrFail();
    return view('layouts.product.edit', compact('product'));
  }
  public function update(ProductUpdateRequest $request, $slug)
  {
    // dd($id);
    $product = Product::where('slug', $slug)
      ->firstOrFail();
    $product->name = $request['name'];
    $product->slug = $request['slug'];
    $product->price = $request['price'];
    $product->brand = $request['brand'];
    $product->short_description = $request['short_description'];
    $product->description = $request['description'];

    $image = $request->file("image");
    if ($image) {
      $image_ext = $image->getClientOriginalExtension();
      $image_name = Str::random(10);
      $image_full_name = $image_name . "." . $image_ext;

      $upload_path = "images/product/";
      $image_url = $upload_path . $image_full_name;
      $success = $image->move($upload_path, $image_full_name);
      if ($success) {
        $product->thumbnail = $image_url;
      }
    }

    $product->update();
    return back()->withSuccess('Product Updated Successfully');;
  }
  public function delete($slug)
  {
    // dd('dljldk');
    $product = Product::where('slug', $slug)->firstOrFail();
    $product->delete();
    $datas = Product::orderBy('id', 'desc')
    ->paginate(10);

  $columns = Product::columns();
  return view('layouts.table', compact('datas', 'columns'))->render();
  }
}
