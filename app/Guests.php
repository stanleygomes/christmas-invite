<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guests extends Model {
    protected $table = 'guests';
    protected $fillable = [
        'name', 'email', 'event_id', 'token', 'companion', 'allergies', 'guest_food', 'companion_food', 'companion_name'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeActive ($query) {
        return $query->where('guests.status', '1');
    }
}
