<?php

namespace App\Http\Controllers\bo;

use App\GuestsHistoryStatus;

class GuestsHistoryStatusBO {

    public function __construct () {

    }

    public function items ($filter = null, $paginate = false, $limit = 30) {

        if ($filter == null) {
            $filter['name'] = '';
        }

        $guests = GuestsHistoryStatus::active();

        if ($filter['name'] != ''){
            $guests->where('name', 'like', '%' . $filter['name'] . '%');
        }

        if ($paginate) {
            $guests = $guests->paginate($limit);
        } else {
            $guests = $guests->take($limit)
                ->get();
        }

        return $guests;
    }
}