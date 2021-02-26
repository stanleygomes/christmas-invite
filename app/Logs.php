<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model {
    protected $table = 'logs';
    protected $fillable = [
        'user_id', 'date_in', 'date_out', 'token', 'action', 'data'
    ];
    protected $dates = ['date_in', 'date_out'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeMine () {
        return $query->where('user_id', \Auth::user()->id);
    }

    public function scopeActive ($query) {
        return $query->where('logs.status', '1');
    }
}
