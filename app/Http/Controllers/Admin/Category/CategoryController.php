<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryInputRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;

class CategoryController extends Controller
{
  public function view()
  {
    $datas = Category::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $columns = Category::columns();
    $model = 'category';
    if (request('per-page') or request('page')) {
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }
  public function search()
  {
    $datas = Category::where('name', 'LIKE', "%" . request('query') . "%")
      ->pagination(request('per-page'));
    $columns = Category::columns();
    $model = 'category';
    return view('layouts.data.table', compact('datas', 'columns', 'model'));
  }
  public function create()
  {
    return view('layouts.category.create');
  }
  public function store(CategoryInputRequest $request)
  {
    $product = new Category();
    $product->name = $request['name'];
    $product->slug =  time() .'-'.Str::slug($request['name']);
    $product->price = $request['price'];
    $product->icon = $request['icon'];
    $product->parent_id = $request['parent_id'];
    $request->user()->categories()->save($product);
    return redirect('admin/view/category')->withSuccess('Category Created Successfully');
  }
  public function edit($slug)
  {
    $data = Category::where('slug', $slug)->firstOrFail();
    $columns = Category::edit_columns();
    $model = 'category';
    return view('layouts.data.edit', compact('data', 'columns', 'model'));
  }
  public function update(CategoryUpdateRequest $request, $slug)
  {
    $product = Category::where('slug', $slug)
      ->firstOrFail();
    $product->name = $request['name'];
    $product->price = $request['price'];
    $product->icon = $request['icon'];
    $product->parent_id = $request['parent_id'];

    $product->update();
    return back()->withSuccess('Category Updated Successfully');;
  }
  public function delete($slug)
  {
    $product = Category::where('slug', $slug)->firstOrFail();
    $product->delete();
    $datas = Category::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $columns = Category::columns();
    $model = 'category';
    return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
  }
}
