<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Bag\Order\OrderInput;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderInputRequest;

class OrderController extends Controller
{
    public function view()
    {
      $datas = Order::orderBy('id', 'desc')
        ->pagination(request('per-page'));
      $model = 'order';
      $columns = Order::columns();
  
      if (request('per-page', '') or request('page', '')) {
        return view('layouts.data.table', compact('datas', 'columns', 'model'))->render();
      }
      return view('layouts.data.view', compact('datas', 'columns', 'model'));
    }
    public function create()
  {
    $data = '';
    $columns = Order::create_columns();
    $model = 'order';
    return view('layouts.data.create', compact('data', 'columns', 'model'));
  }
  public function store(OrderInputRequest $request, OrderInput $addressInput)
  {
      dd($request->all());
    $product = new Order();

    $addressInput->storeUpdate($product, $request);

    $request->user()->address()->save($product);

    return redirect('admin/view/address')
      ->withSuccess('Address Created Successfully');
  }
}
