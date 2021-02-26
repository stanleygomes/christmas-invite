<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\bo\EventsBO;

class EventsController extends Controller {
    protected $eventsBO;

    public function __construct (EventsBO $eventsBO) {
        $this->eventsBO = $eventsBO;
    }

    public function index () {
        $filter = \Session::get('filterevents');

        $events = $this->eventsBO->items($filter, true);

        return view('dashboard.events.index', compact('events', 'filter'));
    }

    public function filter (Request $request) {

        $data = $request->all();

        \Session::put('filterevents', $data);

        return redirect()->route('dashboard.events.index');
    }

    public function create () {

        return view('dashboard.events.create');
    }

    public function store (Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'date' => 'required|max:255',
            'time' => 'required|max:255',
            'place' => 'required|max:255'
        ]);

        $create = $this->eventsBO->store($request);

        if ($create[0] != true)
            return redirect()->route('dashboard.events.index')->withErrors($create);

        return redirect()->route('dashboard.events.index')->with('status', $create[1]);
    }

    public function edit ($id) {

        $event = $this->eventsBO->item($id);

        if ($event[0] != true)
            return redirect()->route('dashboard.events.index')->withErrors($event[1]);

        $event = $event[1];

        return view('dashboard.events.edit', compact('event'));
    }

    public function update (Request $request, $id) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'date' => 'required|max:255',
            'time' => 'required|max:255',
            'place' => 'required|max:255'
        ]);

        $update = $this->eventsBO->update($request, $id);

        if ($update[0] != true)
            return redirect()->route('dashboard.events.index')->withErrors($update);

        return redirect()->route('dashboard.events.index')->with('status', $update[1]);
    }

    public function delete ($id) {

        $delete = $this->eventsBO->delete($id);

        if ($delete[0] != true)
            return redirect()->route('dashboard.events.index')->withErrors($delete);

        return redirect()->back()->with('status', $delete[1]);
    }
}
