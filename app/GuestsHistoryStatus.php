<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestsHistoryStatus extends Model {
    protected $table = 'guests_history_status';
    protected $fillable = [
        'name'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeActive ($query) {
        return $query;
    }
}
