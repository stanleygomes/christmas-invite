<?php

namespace App\Http\Controllers;

class DashboardController extends Controller {

    public function __construct () {
    }

    public function dashboard() {

        return redirect()->route('dashboard.guests.index');
        // return view('dashboard.dashboard');
    }
}