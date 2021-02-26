<?php

namespace App\Http\Controllers\bo;

use App\Logs;
use App\Http\Controllers\bo\UsersBO;

class LogsBO {

    public function store ($data, $userID = false) {

        if (!$userID && \Auth::user()) {
            $userID = \Auth::user()->id;
        }
        else if (!$userID && !\Auth::user()) {
            $userID = 0;
        }

        try {

            $logs = Logs::create();
            $logs->action = $data['action'];
            $logs->data = $data['data'];
            $logs->user_id = $userID;
            $logs->status = 1;
            $logs->created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $logs->save();

        } catch (Exception $e) {
            Log::error($e);
        }

        return $logs;
    }
}