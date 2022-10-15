<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ModelTrait
{
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }

    public function getDefinedRelations(){
        return $this->definedRelations ?? [];
    }

    public function getFilters()
    {
        return $this->filters ?? [];
    }
}
