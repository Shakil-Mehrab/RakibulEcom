<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
  public function view()
  {
    $datas = User::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $columns = User::columns();
      $model = 'user';
      if (request('per-page') or request('page')) {
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }
  public function search()
  {
    $query = request('query');
    $datas = User::where('name', 'LIKE', "%" . $query . "%")
      ->pagination(request('per-page'));
    $columns = User::columns();
    $model = 'user';
    return view('layouts.data.table', compact('datas', 'columns', 'model'));
  }
  public function edit($slug)
  {
    $data = User::where('slug', $slug)->firstOrFail();
    $columns = User::edit_columns();
    $model = 'user';
    return view('layouts.data.edit', compact('data', 'model', 'columns'));
  }
  public function update(UserUpdateRequest $request, $slug)
  {
    $product = User::where('slug', $slug)
      ->firstOrFail();
    $product->name = $request['name'];
    $product->email = $request['email'];
    $image = $request->file("image");
    if ($image) {
      if (file_exists($product->thumbnail)) {
        unlink($product->thumbnail);
      }
      $image_ext = $image->getClientOriginalExtension();
      $image_full_name =$product->id.'.'. Str::random(10). "." . $image_ext;
      $upload_path = "images/user/thumbnail/" . $image_full_name;
      Image::make($request->file('image'))->resize(200, 200)->save($upload_path);
      $product->thumbnail = $upload_path;
    }
    $product->update();
    return back()->withSuccess('User Updated Successfully');;
  }
  public function delete($slug)
  {
    $product = User::where('slug', $slug)->firstOrFail();
    if (file_exists($product->thumbnail)) {
      unlink($product->thumbnail);
    }
    $product->delete();
    $datas = User::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $columns = User::columns();
    $model = 'product';
    return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
  }
}
