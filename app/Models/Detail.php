<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Detail extends Model
{
    use HasFactory;
    protected $casts = [
        'images' => 'array',
        'prices' => 'array',
    ];

    public function setQuestionIdAttribute($value)
    {
        $this->attributes['question_id'] = $value ?? 0;
    }

    public function setPricesAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value);
        }
        if (empty($value)) {
            $value = array();
        }
        $this->attributes['prices'] = json_encode($value);
    }

    public function getPricesAttribute($value)
    {
        return json_decode($value);
    }

    public function setImagesAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value);
        }
        if (empty($value)) {
            $value = array();
        }
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function filters(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Filter', 'App\Models\FilterDetail');
    }

    public function attribute(): HasManyThrough
    {
        return $this->hasManyThrough('App\Models\Attribute', 'App\Models\AttributeDetail', 'detail_id', 'id', 'id', 'attribute_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo('App\Models\Question');
    }
}
