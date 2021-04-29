<?php

namespace App\Bag\Category;

class CategoryInput
{
    public function storeUpdate($product,$request){
        $product->name = $request['name'];
        $product->price = $request['price'];
        $product->icon = $request['icon'];
        $product->parent_id = $request['parent_id'];
    }
}
