<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model {
    protected $table = 'events';
    protected $fillable = [
        'name', 'date', 'place'
    ];
    protected $dates = ['date'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeActive($query)
    {
        return $query->where('events.status', '1');
    }
}
