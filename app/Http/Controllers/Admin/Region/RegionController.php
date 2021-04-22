<?php

namespace App\Http\Controllers\Admin\Region;

use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Region\RegionInputRequest;
use App\Http\Requests\Region\RegionUpdateRequest;

class RegionController extends Controller
{
  public function view()
  {
    $datas = Region::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $columns = Region::columns();
    $model = 'region';
    if (request('per-page') or request('page')) {
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
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
    return view('layouts.region.create');
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
    $model = 'region';
    return view('layouts.data.edit', compact('data', 'columns', 'model'));
  }
  public function update(RegionUpdateRequest $request, $slug)
  {
    $product = Region::where('slug', $slug)
      ->firstOrFail();
    $product->name = $request['name'];
    $product->parent_id = $request['parent_id'];
    $product->update();
    return back()->withSuccess('Region Updated Successfully');;
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
