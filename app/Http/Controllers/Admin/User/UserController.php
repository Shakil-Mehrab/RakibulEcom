<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
  public function view()
  {
    if (request('per-page')) {
      $datas = User::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $columns = User::columns();
      $model = 'user';

      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    if (request('page')) {
      $datas = User::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $columns = User::columns();
      $model = 'user';
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }

    $datas = User::orderBy('id', 'desc')
      ->pagination(request('per-page'));

    $columns = User::columns();
    $model = 'user';
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }

  public function search()
  {
    $query = request('query');
    $datas = User::where('name', 'LIKE', "%" . $query . "%")
      ->pagination(request('per-page'));
    $columns = User::columns();
    $model = 'user';
    return view('layouts.table', compact('datas', 'columns', 'model'));
  }


  public function edit($slug)
  {
    $data = User::where('slug', $slug)
      ->firstOrFail();
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
    // dd($image);
    if ($image) {
      $image_ext = $image->getClientOriginalExtension();
      $image_name = Str::random(10);
      $image_full_name = $image_name . "." . $image_ext;

      $upload_path = "images/user/";
      $image_url = $upload_path . $image_full_name;
      $success = $image->move($upload_path, $image_full_name);
      if ($success) {
        $product->thumbnail = $image_url;
      }
    }
    $product->update();
    return back()->withSuccess('User Updated Successfully');;
  }
  public function delete($slug)
  {
    $product = User::where('slug', $slug)->firstOrFail();
    $product->delete();
    $datas = User::orderBy('id', 'desc')
      ->pagination(request('per-page'));

    $columns = User::columns();
    $model = 'product';
    return view('layouts.table', compact('datas', 'columns', 'model'))->render();
  }
}
