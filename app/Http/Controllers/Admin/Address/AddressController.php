<?php

namespace App\Http\Controllers\Admin\Address;

use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Bag\Delete\DeleteData;
use App\Bag\Address\AddressInput;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressInputRequest;
use App\Http\Requests\Address\AddressUpdateRequest;

class AddressController extends Controller
{
  public function view()
  {
    $datas = Address::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $model = 'address';
    $columns = Address::columns();

    if (request('per-page', '') or request('page', '')) {
      return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
    }
    return view('layouts.data.view', compact('datas', 'columns', 'model'));
  }

  public function search()
  {
    $datas = Address::where('name', 'LIKE', "%" . request('query') . "%")
      ->searchPagination(request('per-page'));
    $columns = Address::columns();
    $model = 'address';
    return view('layouts.data.table', compact('datas', 'columns', 'model'));
  }
  public function create()
  {
    $data = '';
    $columns = Address::create_columns();
    $model = 'address';
    return view('layouts.data.create', compact('data', 'columns', 'model'));
  }
  public function store(AddressInputRequest $request, AddressInput $addressInput)
  {
    $product = new Address();

    $addressInput->storeUpdate($product, $request);

    $request->user()->address()->save($product);

    return redirect('admin/view/address')
      ->withSuccess('Address Created Successfully');
  }
  public function edit($slug)
  {
    $data = Address::where('slug', $slug)->firstOrFail();
    $columns = Address::edit_columns();
    $model = 'address';
    return view('layouts.data.edit', compact('data', 'columns', 'model'));
  }
  public function update(AddressUpdateRequest $request,AddressInput $addressInput, $slug)
  {
    $product = Address::where('slug', $slug)
      ->firstOrFail();
    $addressInput->storeUpdate($product, $request);
    $product->update();
    return back()->withSuccess('Address Updated Successfully');;
  }
  public function delete(DeleteData $delete, $slug)
  {
    $delete->addressDelete($slug);
    $datas = Address::orderBy('id', 'desc')
      ->pagination(request('per-page'));
    $columns = Address::columns();
    $model = 'address';
    return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
  }
}
