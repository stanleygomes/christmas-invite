<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Input;
use App\Http\Requests;
use App\Http\Helpers;
use App\User;
use App\Logs;
use Auth;

use App\Http\Controllers\bo\UsersBO;
use App\Http\Controllers\bo\LogsBO;

class UserController extends Controller {

    protected $usersBO;
    protected $logsBO;

    public function __construct (UsersBO $usersBO, LogsBO $logsBO) {
        $this->usersBO = $usersBO;
        $this->logsBO = $logsBO;
    }

    public function auth () {

        if(Auth::check())
            return redirect()->route('dashboard.dashboard');

        return view('auth.index');
    }

    public function login (Request $request) {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $auth = $this->usersBO->validateLogin($request);

        if ($auth[0] != true)
            return redirect()->route('auth.index')->withErrors($auth);

        $user = $auth[1];

        Auth::login($user);

        $log = $this->logsBO->store(['action' => 'login', 'data' => $user], $user->id);

        \Session::put('log_id', $log->id);

        return redirect()->route('dashboard.dashboard');
    }

    public function logout() {

        $session = $this->usersBO->dropUserSession();

        return redirect()->route('auth.login');
    }

    public function passwordRequest () {

        if(Auth::check())
            return redirect()->route('dashboard.dashboard');

        return view('auth.password-request');
    }

    public function passwordRequestPost (Request $request) {

        $passwordRequest = $this->usersBO->passwordChangeRequest($request->email);

        if ($passwordRequest[0] != true)
            return redirect()->back()->withErrors($passwordRequest);

        return redirect()->route('auth.index')->with('status', $passwordRequest[1]);
    }

    public function passwordResetToken ($token) {

        $validateToken = $this->usersBO->validatetoken($token);

        if ($validateToken[0] != true)
            return redirect()->route('auth.index')->withErrors($validateToken);

        return view('auth.password-reset');
    }

    public function passwordResetTokenPost (Request $request, $token) {

        $validatetoken = $this->usersBO->validatetoken($token);

        if ($validatetoken[0] != true)
            return redirect()->route('auth.index')->withErrors($validatetoken);

        echo $request->email = $validatetoken[1]->email;
            echo $token;

        $passwordReset = $this->usersBO->passwordReset($request, $token);

        return redirect()->route('auth.index')->with('status', $passwordReset[1]);
    }

	public function index () {

        $filter = \Session::get('filterusers');

        $users = $this->usersBO->getUsers($filter, true);

        return view('dashboard.user.index', compact('users', 'filter'));
    }

    public function filter (Request $request) {

        $data = $request->all();

        \Session::put('filterusers', $data);

        return redirect()->route('dashboard.users');
    }

    public function profile ($id = false) {

        $userID = $id > 0 ? $id : \Auth::user()->id;

        if(\Auth::user()->type != 0)
            $userID = \Auth::user()->id;

        $user = $this->usersBO->getUser($userID);

        $address = $this->usersBO->joinAddress($user);

        return view('dashboard.user.profile', compact('user', 'address'));
    }

    public function passwordEdit () {

        return view('dashboard.user.password-edit');
    }

    public function passwordUpdate (Request $request) {

        $this->validate($request, [
            'today' => 'required',
            'new' => 'required',
            'repeat' => 'required'
        ]);

        $passwordChange = $this->usersBO->validPasswordChange($request);

        if ($passwordChange[0] != true)
            return redirect()->route('auth.index')->withErrors($passwordChange);

        return redirect()->route('dashboard.users')->with('status', $passwordChange[1]);
    }

    public function passwordReset ($id) {

        $passwordReset = $this->usersBO->validPasswordReset($user);

        if ($passwordReset[0] != true)
            return redirect()->route('auth.index')->withErrors($passwordReset);

        return redirect()->route('dashboard.auth')->with('status', $passwordReset[1]);
   }

    public function edit ($id = false) {

        if($id > 0)
            $us = $id;
        else
            $us = \Auth::user()->id;
        
        $user = $this->usersBO->getUser($us);

        if(!$user)
            return redirect()->route('dashboard.users');

        return view('dashboard.user.edit', compact('user'));
    }

    public function update (Request $request, $id = false) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'type' => 'required'
        ]);

        if($id > 0)
            $us = $id;
        else
            $us = \Auth::user()->id;

        $userUpdate = $this->usersBO->update($request, $id);

        if (!$userUpdate)
            return redirect()->route('dashboard.users')->withErrors($userUpdate);

        return redirect()->route('dashboard.users')->with('status', $userUpdate[1]);
    }

    public function status ($type, $id) {

        $statusChange = $this->usersBO->statusChange($type, $id);

        if ($statusChange[0] != true)
            return redirect()->route('dashboard.users')->withErrors($statusChange);

        return redirect()->route('dashboard.users')->with('status', $statusChange[1]);
    }

    public function create () {

        return view('dashboard.user.create');
    }

    public function store (Request $request, $callback = false) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'type' => 'required'
        ]);

        $store = $this->usersBO->store($request, $callback);

        if ($store[0] != true)
            return redirect()->route('dashboard.users')->withErrors($store);

        return redirect()->route('dashboard.users')->with('status', $store[1]);
    }
}
