<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewGuestsHistoryLastStatus extends Model {
    protected $table = 'view_guests_history_last_status';
    protected $fillable = [
        'history_id', 'guest_id', 'status_id', 'status_name'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
