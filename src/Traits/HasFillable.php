<?php

namespace Bastinald\Malzahar\Traits;

use Illuminate\Support\Facades\Schema;

trait HasFillable
{
    /**
     * Generate a list of fillable columns.
     *
     * @return array
     */
    public function getFillable(): array
    {
        return Schema::getColumnListing($this->getTable());
    }
}
