<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Size;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Product\ProductInputRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductController extends Controller
{
  public function view()
  {
    $datas = Product::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $model = 'product';
    $columns = Product::columns();
   
    if (request('per-page','') or request('page','')) {
      dump(request('per-page',''));
      dump(request('page',''));
  // dd('ok');
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
    return view('layouts.product.create');
  }
  public function store(ProductInputRequest $request)
  {

    $product = new Product();
    $product->name = $request['name'];
    $product->slug = time() . '-' . Str::slug($request['name']);
    $product->price = $request['price'];
    $product->brand = $request['brand'];
    $product->short_description = $request['short_description'];
    $product->description = $request['description'];
    $this->uploadImage($product, $request);

    $request->user()->products()->save($product);

    $this->uploadRelatedImage($product, $request);
    $this->productPivotData($product, $request);

    return redirect('admin/view/product')
      ->withSuccess('Product Created Successfully');
  }
  public function edit($slug)
  {
    $data = Product::where('slug', $slug)->firstOrFail();
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
    $this->uploadImage($product, $request);

    $this->uploadRelatedImage($product, $request);
    $this->productPivotData($product, $request);

    $product->update();

    return back()->withSuccess('Product Updated Successfully');;
  }
  public function delete($slug)
  {
    $product = Product::where('slug', $slug)->firstOrFail();
    if (file_exists($product->thumbnail)) {
      unlink($product->thumbnail);
    }
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
  public function uploadImage($product, $request)
  {
    
    $image = $request->file("image");
    if ($image) {
      if (file_exists($product->thumbnail)) {
        unlink($product->thumbnail);
      }
      $image_ext = $image->getClientOriginalExtension();
      $image_full_name = Str::random(10). "." . $image_ext;
      $upload_path = "images/product/thumbnail/" . $image_full_name;
      Image::make($request->file('image'))->resize(200, 200)->save($upload_path);
      $product->thumbnail = $upload_path;
    }
    return;
  }
  public function uploadRelatedImage($product, $request)
  {
   
    $images = $request->file("images");
    if ($images) {
      foreach ($images as $image) {
        $image_ext = $image->getClientOriginalExtension();
        $image_full_name =$product->id.'.'.Str::random(10). "." .$image_ext;
        $upload_path = "images/product/related/" . $image_full_name;
        Image::make($image)->resize(200, 200)->save($upload_path);

        $produtImage = new ProductImage();
        $produtImage->product_id = $product->id;
        $produtImage->thumbnail = $upload_path;
        $produtImage->save();
      }
    }
    return;
  }
}
