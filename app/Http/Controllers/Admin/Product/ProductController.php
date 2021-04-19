<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductInputRequest;
use Symfony\Component\Console\Input\Input;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
  public function view()
  {
    if (request('per-page')) {
      $datas = Product::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $columns = Product::columns();
      $model = 'product';

      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    if (request('page')) {
      $datas = Product::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $columns = Product::columns();
      $model = 'product';
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }

    $datas = Product::orderBy('id', 'desc')
      ->pagination(request('per-page'));

    $columns = Product::columns();
    $model = 'product';
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }

  public function search()
  {
    $query = request('query');
    $datas = Product::where('name', 'LIKE', "%" . $query . "%")
      ->pagination(request('per-page'));
    $columns = Product::columns();
    $model = 'product';
    return view('layouts.data.table', compact('datas', 'columns', 'model'));
  }
  public function create()
  {
    $categories=Category::orderBy('name','asc')->get();
    return view('layouts.product.create',compact('categories'));
  }
  public function store(ProductInputRequest $request)
  {
    
    $product = new Product();
    $product->name = $request['name'];
    $product->slug = time().'&'.Str::slug($request['name']);
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
    $product->categories()
            ->sync(
              $request['category_id']
            );
    return redirect('admin/view/product')
      ->withSuccess('Product Created Successfully');
  }
  public function edit($slug)
  {
    $data = Product::where('slug', $slug)
      ->firstOrFail();
    // return $data->categories[0]['name'];

    $columns = Product::edit_columns();
    $model = 'product';
    return view('layouts.data.edit', compact('data', 'columns', 'model'));
  }
  public function update(ProductUpdateRequest $request, $slug)
  {
    $product = Product::where('slug', $slug)
      ->firstOrFail();
    $product->name = $request['name'];
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
    $product = Product::where('slug', $slug)->firstOrFail();
    $product->delete();
    $datas = Product::orderBy('id', 'desc')
      ->pagination(request('per-page'));

    $columns = Product::columns();
    $model = 'product';
    return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
  }
}
