<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    public function detail(): HasMany
    {
        return $this->hasMany('App\Models\Detail', 'service_id');
    }

    public function filters(): HasMany
    {
        return $this->hasMany('App\Models\Detail', 'service_id')
            ->leftJoin('filter_details', 'detail_id', '=', 'details.id')
            ->join('filters', 'filter_id', '=', 'filters.id')
            ->select(['filters.id', 'filters.title'])
            ->groupBy('filters.id', 'filters.title');
    }
}
