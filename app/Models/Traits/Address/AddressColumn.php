<?php

namespace App\Models\Traits\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Schema;

trait AddressColumn
{
    public static function columns()
    {
        return collect(Schema::getColumnListing(Address::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['uuid','created_at','updated_at']);

            })
            ->toArray();
    }
    public static function create_columns()
    {
        return collect(Schema::getColumnListing(Address::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['id','uuid','user_id','slug','order','default','created_at','updated_at','deleted_at']);

            })
            ->toArray();
    }
    public static function edit_columns()
    {
        return collect(Schema::getColumnListing(Address::getQuery()->from))
            ->reject(function ($column) {
                return in_array($column,['id','uuid','user_id','slug','order','default','created_at','updated_at','deleted_at']);

            })
            ->toArray();
    }
}
