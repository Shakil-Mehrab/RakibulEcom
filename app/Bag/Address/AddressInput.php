<?php

namespace App\Bag\Address;

class AddressInput
{
    public function storeUpdate($product,$request)
    {
        $product->country_id = $request['country_id'];
        $product->district_id = $request['district_id'];
        $product->place_id = $request['place_id'];
        $product->address = $request['address'];
        $product->postal_code = $request['postal_code'];
    }
}
