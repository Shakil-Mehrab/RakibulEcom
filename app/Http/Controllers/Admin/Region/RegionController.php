<?php

namespace App\Http\Controllers\Admin\Region;

use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegionInputRequest;
use App\Http\Requests\RegionUpdateRequest;

class RegionController extends Controller
{
    public function view()
    {
      if (request('per-page')) {
        $datas = Region::orderBy('id', 'desc')
          ->pagination(request('per-page'));
        $columns = Region::columns();
        $model = 'region';
  
        return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
      }
      if (request('page')) {
        $datas = Region::orderBy('id', 'desc')
          ->pagination(request('per-page'));
        $columns = Region::columns();
        $model = 'region';
        return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
      }
  
      $datas = Region::orderBy('id', 'desc')
        ->pagination(request('per-page'));
  
      $columns = Region::columns();
      $model = 'region';
      return view('layouts.data.view', compact('datas', 'columns', 'model'));
    }
  
    public function search()
    {
      $query = request('query');
      $datas = Region::where('name', 'LIKE', "%" . $query . "%")
        ->pagination(request('per-page'));
      $columns = Region::columns();
      $model = 'region';
      return view('layouts.data.table', compact('datas', 'columns', 'model'));
    }
    public function create()
    {
      $categories=Region::orderBy('name','asc')->get();
      return view('layouts.region.create',compact('categories'));
    }
    public function store(RegionInputRequest $request)
    {
      $product = new Region();
      $product->name = $request['name'];
    $product->parent_id = $request['parent_id'];
      $product->save();
      return redirect('admin/view/region')
        ->withSuccess('Region Created Successfully');
    }
    public function edit($slug)
    {
      $data = Region::where('slug', $slug)
        ->firstOrFail();
      $columns = Region::edit_columns();
    $categories = Region::orderBy('name','asc')->get();

      $model = 'region';
      return view('layouts.data.edit', compact('data', 'columns', 'model','categories'));
    }
    public function update(RegionUpdateRequest $request, $slug)
    {
      $product = Region::where('slug', $slug)
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
      $product = Region::where('slug', $slug)->firstOrFail();
      $product->delete();
      $datas = Region::orderBy('id', 'desc')
        ->pagination(request('per-page'));
  
      $columns = Region::columns();
      $model = 'region';
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
}
