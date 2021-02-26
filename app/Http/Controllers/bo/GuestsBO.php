<?php

namespace App\Http\Controllers\bo;

use App\Guests;
use App\ViewGuestsHistory;
use App\ViewGuestsHistoryLastStatus;
use App\ViewGuestsHistoryStatusCount;
use App\Http\Controllers\bo\LogsBO;
use App\Http\Controllers\bo\GuestsHistoryBO;
use App\Http\Controllers\bo\EventsBO;
use App\Http\Controllers\bo\EmailsBO;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class GuestsBO {
    protected $logsBO;
    protected $guestsHistoryBO;
    protected $eventsBO;
    protected $emailsBO;

    public function __construct (LogsBO $logsBO, GuestsHistoryBO $guestsHistoryBO, EventsBO $eventsBO, EmailsBO $emailsBO) {
        $this->logsBO = $logsBO;
        $this->guestsHistoryBO = $guestsHistoryBO;
        $this->eventsBO = $eventsBO;
        $this->emailsBO = $emailsBO;
    }

    public function getGuest ($id) {
        $guest = Guests::active()
            ->where('id', $id)
            ->first();

        return $guest;
    }

    public function getGuestLastHistoryByToken ($token) {

        $guest = ViewGuestsHistory::where('token', $token)
            ->first();

        return $guest;
    }

    public function items ($filter = null, $paginate = false, $limit = 30) {
        if ($filter == null) {
            $filter['name'] = '';
            $filter['event_id'] = 0;
            $filter['status_id'] = 0;
        }

        $guests = ViewGuestsHistory::join('events', 'events.id', '=', 'view_guests_history.event_id')
            ->where('view_guests_history.id', '>', 0)
            ->select(
                'view_guests_history.id', 'view_guests_history.name',
                'view_guests_history.status_id','view_guests_history.status_color',
                'view_guests_history.email', 'view_guests_history.status_name',
                'events.name as event_name'
            );

        if ($filter['name'] != '') {
            $guests->where('view_guests_history.name', 'like', '%' . $filter['name'] . '%');
        }

        if ($filter['event_id'] > 0) {
            $guests->where('view_guests_history.event_id', $filter['event_id']);
        }

        if ($filter['status_id'] > 0) {
            $guests->where('view_guests_history.status_id', $filter['status_id']);
        }

        if ($paginate) {
            $guests = $guests->paginate($limit);
        } else {
            $guests = $guests->take($limit)
                ->get();
        }

        return $guests;
    }

    public function itemsCount ($event_id) {
        return ViewGuestsHistory::where('event_id', $event_id)
            ->count();
    }

    public function guestsStatusCount ($event_id, $totalCount = 0) {
        $guestsStatusCount = ViewGuestsHistoryStatusCount::where('event_id', $event_id)
            ->get();

        $statusCount = [
            'invite_sent' => 0,
            'open_link' => 0,
            'confirmed' => 0,
            'invite_sent_percentage' => 0,
            'open_link_percentage' => 0,
            'confirmed_percentage' => 0
        ];

        foreach ($guestsStatusCount as $count) {
            switch ($count->status_id) {
                case 3:
                    $statusCount['confirmed'] = $count->count;
                    break;
                case 2:
                    $statusCount['open_link'] = $count->count;
                    break;
                case 1:
                    $statusCount['invite_sent'] = $count->count;
                    break;
                default:
                    break;
            }
        }

        $statusCount['open_link'] += $statusCount['confirmed'];
        $statusCount['invite_sent'] += $statusCount['open_link'];

        $statusCount['confirmed_percentage'] = $totalCount > 0 ? round(($statusCount['confirmed'] / $totalCount) * 100, 2) : 0;
        $statusCount['open_link_percentage'] = $totalCount > 0 ? round(($statusCount['open_link'] / $totalCount) * 100, 2) : 0;
        $statusCount['invite_sent_percentage'] = $totalCount > 0 ? round(($statusCount['invite_sent'] / $totalCount) * 100, 2) : 0;

        return $statusCount;
    }

    public function store ($request) {
        $guest = Guests::create();
        $guest->name = $request->name;
        $guest->event_id = $request->event_id;
        $guest->email = $request->email;
        $guest->user_created = \Auth::user()->id;
        $guest->token = md5(rand(1, 1000).time());
        $guest->status = 1;
        $guest->created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $guest->save();

        // insert history
        $guest->guest_id = $guest->id;
        $guest->status_id = 1;
        $this->guestsHistoryBO->store($guest);

        // buscar dados do evento
        $eventData = $this->eventsBO->getEvent($request->event_id);

        if ($eventData) {
            $guest->event_id = $eventData->id;
            $guest->event_name = $eventData->name;
            $guest->event_date = $eventData->date;
            $guest->event_place = $eventData->place;
        }

        if ($request->send == 'on') {
            $this->emailsBO->guestInvite($guest->token, $guest);
        }

        $log = $this->logsBO->store(['action' => 'create_guest', 'data' => $guest]);

        return [true, 'Guest stored successfully!'];
    }

    public function item ($id) {
        if ($id > 0){

            $guest = GuestsBO::getGuest($id);
            
            if (!$guest){
                return [false, 'Guest not found.'];
            }
        }
        else{
            return [false, 'Guest not found.'];
            return redirect()->back()->with('status', '');
        }

        return [true, $guest];
    }

    public function update ($request, $id) {
        $guest = GuestsBO::getGuest($id);

        if (!$guest) {
            return [false, 'Guest not found.'];
        }

        $guest->name = $request->name;
        $guest->email = $request->email;
        $guest->save();

        $this->logsBO->store(['action' => 'update_guest', 'data' => $guest]);

        return [true, 'Guest updated successfully!'];
    }

    public function updateCompanion ($id, $request) {
        $guest = GuestsBO::getGuest($id);

        if (!$guest) {
            return [false, 'Guest not found.'];
        }

        $guest->companion = $request->companion;
        $guest->guest_food = $request->guest_food;
        $guest->allergies = $request->allergies;

        if ($guest->companion == 1) {
            $guest->companion_food = $request->companion_food;
            $guest->companion_name = $request->companion_name;
        }

        $guest->save();

        $this->logsBO->store(['action' => 'update_guest', 'data' => $guest]);

        return [true, 'Guest updated successfully!'];
    }

    public function delete ($id) {
        $guest = GuestsBO::getGuest($id);

        if (!$guest) {
            return [false, 'Guest not found.'];
        }

        $guest->status = 2;
        $guest->deleted_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $guest->save();

        $this->logsBO->store(['action' => 'delete_guest', 'data' => $guest]);

        return [true, 'Guest deleted successfully!'];
    }

    public function download ($id) {
        if ($id == 0) {
            $event = $this->eventsBO->getLastEvent();
            $event_id = $event->id;
        } else {
            $event_id = $id;
        }

        $data = ViewGuestsHistory::select(
            'event_name',
            'name as guest_name',
            'email as guest_email',
            'status_name as status',
            'history_date as date',
            'companion as bring_guest',
            'allergies',
            'guest_food',
            'companion_food',
            'companion_name'
            )
            ->where('event_id', $event_id)
            ->get()
            ->toArray();

        return Excel::create('Guests '.date('Y-m-d|H:i:s'), function ($excel) use ($data) {
            $excel->sheet('Guests', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}