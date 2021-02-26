<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewGuestsHistory extends Model {
    protected $table = 'view_guests_history';
    protected $fillable = [
        'name', 'email', 'companion', 'created_at', 'event_id', 'history_id',
        'guest_id', 'status_id', 'status_name',
        'allergies', 'guest_food', 'companion_food', 'companion_name'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
