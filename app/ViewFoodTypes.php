<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewFoodTypes extends Model {
    protected $table = 'view_food_types';
    protected $fillable = [
        'id', 'food_type', 'event_id'
    ];
    protected $dates = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function getFoodTypes () {
        return ViewFoodTypes::get();
    }

    public function getFoodType ($id) {
        return ViewFoodTypes::where('id', $id)
            ->first();
    }
}