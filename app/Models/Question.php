<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;
    protected $casts = [
        'faq' => 'array',
    ];

    public function setFaqAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        if (empty($value)) {
            $value = array();
        }
        $this->attributes['faq'] = json_encode($value);
    }

    public function getFaqAttribute($value)
    {
        return json_decode($value);
    }

    public function detail(): HasMany
    {
        return $this->hasMany('App\Models\Detail', 'question_id');
    }
}
