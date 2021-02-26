<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestsHistory extends Model {
    protected $table = 'guests_history';
    protected $fillable = [
        'status'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeActive ($query) {
        return $query->where('guests_history.status', '1');
    }
}
