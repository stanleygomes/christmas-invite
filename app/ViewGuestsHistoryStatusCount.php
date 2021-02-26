<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewGuestsHistoryStatusCount extends Model {
    protected $table = 'view_guests_history_status_count';
    protected $fillable = [
        'count', 'status_id', 'status_name', 'event_id'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
