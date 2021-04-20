<?php

namespace App\Models\Traits\Product;

use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;

trait ProductPivotTable
{
  public function product_category(Builder $builder){
      dd('klk');
  }
}
