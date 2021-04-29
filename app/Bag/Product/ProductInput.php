<?php

namespace App\Bag\Product;

class ProductInput
{
    public function storeUpdate($product,$request){
      $product->name = $request['name'];
      $product->price = $request['price'];
      $product->brand = $request['brand'];
      $product->short_description = $request['short_description'];
      $product->description = $request['description'];
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
