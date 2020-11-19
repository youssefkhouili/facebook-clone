<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function getFormattedDateAttribute()
    {
        return optional($this->created_at)->diffsForHumans();
    }
}
