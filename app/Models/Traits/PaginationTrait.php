<?php

namespace App\Models\Traits;

use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;

trait PaginationTrait
{
    public function scopePagination($query,$per_page)
    {
        return $query->paginate(request('per-page',10));
    }
}
