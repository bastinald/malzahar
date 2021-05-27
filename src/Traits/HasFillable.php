<?php

namespace Bastinald\Malzahar\Traits;

use Illuminate\Support\Facades\Schema;

trait HasFillable
{
    public function getFillable()
    {
        return Schema::getColumnListing($this->getTable());
    }
}
