<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryInputRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
  public function view()
  {
    if (request('per-page')) {
      $datas = Category::orderBy('id', 'desc')
        ->pagination(request('per-page'));

      $columns = Category::columns();
      $model = 'category';

      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    if (request('page')) {
      $datas = Category::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $columns = Category::columns();
      $model = 'category';
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }

    $datas = Category::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $columns = Category::columns();
    $model = 'category';
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }
  public function search()
  {
    $query = request('query');
    $datas = Category::where('name', 'LIKE', "%" . $query . "%")
      ->pagination(request('per-page'));
    $columns = Category::columns();
    $model = 'category';
    return view('layouts.data.table', compact('datas', 'columns', 'model'));
  }
  public function create()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    return view('layouts.category.create', compact('categories'));
  }
  public function store(CategoryInputRequest $request)
  {
    $product = new Category();
    $product->name = $request['name'];
    $product->slug = Str::slug($request['name']);
    $product->price = $request['price'];
    $product->icon = $request['icon'];
    $product->parent_id = $request['parent_id'];
    $request->user()->categories()->save($product);
    return redirect('admin/view/category');
  }
  public function edit($slug)
  {
    $categories=Category::orderBy('name','asc')->get();
    $data = Category::where('slug', $slug)
      ->firstOrFail();
    $columns = Category::edit_columns();
    $model = 'category';
    return view('layouts.data.edit', compact('data', 'columns', 'model','categories'));
  }
  public function update(CategoryUpdateRequest $request, $slug)
  {
    // dd($id);
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
