<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\bo\GuestsBO;
use App\Http\Controllers\bo\EventsBO;
use App\Http\Controllers\bo\GuestsHistoryStatusBO;

class GuestsController extends Controller {
    protected $guestsBO;
    protected $eventsBO;
    protected $guestsHistoryStatusBO;

    public function __construct (GuestsBO $guestsBO, EventsBO $eventsBO, GuestsHistoryStatusBO $guestsHistoryStatusBO) {
        $this->guestsBO = $guestsBO;
        $this->eventsBO = $eventsBO;
        $this->guestsHistoryStatusBO = $guestsHistoryStatusBO;
    }

    public function index () {
        $filter = \Session::get('filterguests');

        if ($filter == null) {
            $filter['name'] = '';
            $filter['status_id'] = 0;
            $lastEvent = $this->eventsBO->getLastEvent();
            $filter['event_id'] = $lastEvent->id > 0 ? $lastEvent->id : 0;
        }

        $guests = $this->guestsBO->items($filter, true);
        $guestsCount = $this->guestsBO->itemsCount($filter['event_id']);
        $statusCount = $this->guestsBO->guestsStatusCount($filter['event_id'], $guestsCount);

        $events = $this->eventsBO->items();
        $historyStatus = $this->guestsHistoryStatusBO->items();

        return view('dashboard.guests.index', compact('guests', 'filter', 'statusCount', 'guestsCount', 'events', 'historyStatus'));
    }

    public function filter (Request $request) {
        $data = $request->all();
        \Session::put('filterguests', $data);

        return redirect()->route('dashboard.guests.index');
    }

    public function create () {
        $events = $this->eventsBO->items();

        return view('dashboard.guests.create', compact('events'));
    }

    public function store (Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255'
        ]);

        $create = $this->guestsBO->store($request);

        if ($create[0] != true)
            return redirect()->route('dashboard.guests.index')->withErrors($create);

        return redirect()->back()->with('status', $create[1]);
    }

    public function edit ($id) {
        $guest = $this->guestsBO->item($id);

        if ($guest[0] != true)
            return redirect()->route('dashboard.guests.index')->withErrors($guest[1]);

        $guest = $guest[1];

        $events = $this->eventsBO->items([
            'name' => '',
            'order' => '0'
        ]);

        return view('dashboard.guests.edit', compact('guest', 'events'));
    }

    public function update (Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $update = $this->guestsBO->update($request, $id);

        if ($update[0] != true)
            return redirect()->route('dashboard.guests.index')->withErrors($update);

        return redirect()->route('dashboard.guests.index')->with('status', $update[1]);
    }

    public function delete ($id) {
        $delete = $this->guestsBO->delete($id);

        if ($delete[0] != true)
            return redirect()->route('dashboard.guests.index')->withErrors($delete);

        return redirect()->back()->with('status', $delete[1]);
    }

    public function download ($id = 0) {
        $this->guestsBO->download($id);

        return redirect()->back();
    }
}
