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
use App\Models\Size;

class ProductController extends Controller
{
  public function view()
  {
    $datas = Product::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $model = 'product';
    $columns = Product::columns();
    if (request('per-page')) {
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    if (request('page')) {
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }

  public function search()
  {
    $datas = Product::where('name', 'LIKE', "%" . request('query') . "%")
      ->pagination(request('per-page'));
    $columns = Product::columns();
    $model = 'product';
    return view('layouts.data.table', compact('datas', 'columns', 'model'));
  }
  public function create()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $sizes = Size::get();
    return view('layouts.product.create', compact('categories', 'sizes'));
  }
  public function store(ProductInputRequest $request)
  {
    $product = new Product();
    $product->name = $request['name'];
    $product->slug = time() .'-'.Str::slug($request['name']);
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
    $this->productPivotData($product, $request);

    return redirect('admin/view/product')
      ->withSuccess('Product Created Successfully');
  }
  public function edit($slug)
  {
    $data = Product::where('slug', $slug)->firstOrFail();
    // return $data->sizes->contains('5');
    $columns = Product::edit_columns();
    $categories = Category::orderBy('name','asc')->get();
    $sizes = Size::get();
    $model = 'product';
    return view('layouts.data.edit', compact('data', 'columns', 'model', 'categories','sizes'));
  }
  public function update(Request $request, $slug)
  {
    // dd($request->all());
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
    $this->productPivotData($product, $request);
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
  public function productPivotData($product, $request)
  {
     $product->categories()
      ->sync(
        $request['category_id']
      );
      $product->sizes()
      ->sync(
        $request['size_id']
      );
      return;
  }
}
