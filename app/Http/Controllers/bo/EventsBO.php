<?php

namespace App\Http\Controllers\bo;

use App\Events;
use App\ViewFoodTypes;
use App\Http\Controllers\bo\LogsBO;

class EventsBO {
    protected $logsBO;

    public function __construct (LogsBO $logsBO) {
        $this->logsBO = $logsBO;
    }

    public function getFoodTypes () {
        $foodTypes = new ViewFoodTypes();
        return $foodTypes->getFoodTypes();
    }

    public function getFoodType ($id) {
        $foodTypes = new ViewFoodTypes();
        return $foodTypes->getFoodType($id);
    }

    public function getEvent ($id) {
        $event = Events::active()
            ->where('id', $id)
            ->first();

        return $event;
    }

    public function items ($filter = null, $paginate = false, $limit = 15) {
        if ($filter == null) {
            $filter['name'] = '';
            $filter['order'] = '';
        }

        $events = Events::active();

        if ($filter['name'] != '')
            $events->where('name', 'like', '%' . $filter['name'] . '%');

        if ($filter['order'] != '1') {
            $events->orderBy('name', 'asc');
        } else if ($filter['order'] != '2') {
            $events->orderBy('created_at', 'desc');
        } else {
            $events->orderBy('created_at', 'desc');
        }

        if ($paginate) {
            $events = $events->paginate($limit);
        } else {
            $events = $events->take($limit)
                ->get();
        }

        return $events;
    }

    public function store ($request) {
        $event = Events::create();
        $event->name = $request->name;
        $event->date = date_create_from_format('d/m/Y H:i:s', $request->date.' '.$request->time.':00');
        $event->place = $request->place;
        $event->status = 1;
        $event->created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $event->save();

        $this->logsBO->store(['action' => 'create_event', 'data' => $event]);

        return [true, 'Event stored successfully!'];
    }

    public function item ($id) {
        if ($id > 0) {
            $event = EventsBO::getEvent($id);

            if (!$event) {
                return [false, 'Event not found.'];
            }
        } else {
            return [false, 'Event not found.'];
            return redirect()->back()->with('status', '');
        }

        return [true, $event];
    }

    public function update ($request, $id) {
        $event = EventsBO::getEvent($id);

        if (!$event) {
            return [false, 'Event not found.'];
        }

        $event->name = $request->name;
        $event->date = date_create_from_format('d/m/Y H:i:s', $request->date . ' ' . $request->time . ':00');
        $event->place = $request->place;
        $event->save();

        $this->logsBO->store(['action' => 'update_event', 'data' => $event]);

        return [true, 'Event updated successfully!'];
    }

    public function delete ($id) {
        $event = EventsBO::getEvent($id);

        if (!$event) {
            return [false, 'Event not found.'];
        }

        $event->status = 2;
        $event->deleted_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $event->save();

        $this->logsBO->store(['action' => 'delete_event', 'data' => $event]);

        return [true, 'Event deleted successfully!'];
    }

    public function getLastEvent() {
        return Events::active()
            ->orderBy('id', 'desc')
            ->first();
    }
}