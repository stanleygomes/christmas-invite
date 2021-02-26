<?php

namespace App\Http\Controllers\bo;

use App\GuestsHistory;
use App\Http\Controllers\bo\LogsBO;

class GuestsHistoryBO {

    protected $logsBO;

    public function __construct (LogsBO $logsBO) {
        $this->logsBO = $logsBO;
    }

    public function store ($request) {

        $guests_history = GuestsHistory::create();
        $guests_history->status_id = $request->status_id;
        $guests_history->guest_id = $request->guest_id;
        $guests_history->user_created = \Auth::user() ? \Auth::user()->id : 1;
        $guests_history->created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $guests_history->save();

        $log = $this->logsBO->store(['action' => 'create_guests_history', 'data' => $guests_history]);

        return [true, 'Created successfully.'];
    }
}