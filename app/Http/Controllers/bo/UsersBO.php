<?php

namespace App\Http\Controllers\bo;

use App\User;
use App\Http\Controllers\bo\EmailsBO;
use App\Http\Controllers\bo\LogsBO;

class UsersBO {

    protected $emailsBO;
    protected $logsBO;

    public function __construct (EmailsBO $emailsBO, LogsBO $logsBO) {
        $this->emailsBO = $emailsBO;
        $this->logsBO = $logsBO;
    }

    public function validateLogin ($data) {

        $user = UsersBO::getUserByEmail($data->email);

        if (!$user)
            return [false, 'This emails is not in our base. Are your sure it is your email?', $data->email];

        if ($user->password != md5($data->password))
            return [false, 'Invalid password. TIP: You can recover it, down below.', $data->email];
        
        return [true, $user];
    }

    public function getUser ($id) {

        $user = User::where('id', $id)
            ->active()
            ->first();

        return $user;
    }

    public function getUsers ($filter = null, $paginate = false, $limit = 15) {

        if ($filter == null) {
            $filter['name'] = '';
            $filter['type'] = '';
            $filter['order'] = '';
        }

        $users = User::active();

        if($filter['name'] != '')
            $users->where('name', 'like', '%'.$filter['name'].'%');

        if($filter['type'] > 0)
            $users->where('type', $filter['type']);

        if($filter['order'] != '1') {
            $users->orderBy('name', 'asc');
        }
        else if($filter['order'] != '2') {
            $users->orderBy('created_at', 'desc');
        }
        else {
            $users->orderBy('created_at', 'desc');
        }

        if ($paginate) {
            $users = $users->paginate($limit);
        }
        else {
            $users = $users->take($limit)
                ->get();
        }

        return $users;
    }

    public function joinAddress ($user) {

        if (!$user) {
            return null;
        }

        $address = "";
        $street = $user->street;
        $number = $user->number;
        $complement = $user->complement;
        $zipcode = $user->zipcode;
        $district = $user->district;
        $city = $user->city;

        if($street != "")
            $address .= $street;
        if($number != "")
            $address .= ", ".$number;
        if($district != "")
            $address .= ", ".$district;
        if($city != "")
            $address .= ", ".$city;
        
        return $address;
    }

    public function getUserByEmail ($email) {

        $user = User::where('email', $email)
            ->active()
            ->first();

        return $user;
    }

    public function dropUserSession () {

        if (\Session::has('log_id')) {
            $log = $this->logsBO->store(['action' => 'logout', 'data' => null]);

            \Session::forget('log_id');
            \Auth::logout();
        }
    }

    public function validPasswordChange ($formData) {

        $user = UsersBO::getUser(\Auth::user()->id);

        if($user->password != md5($formData->today))
            return [false, 'Old password is invalid.'];

        if($formData->new != $formData->repeat)
            return [false, 'Your new and confirmation password are different.'];

        $user->password = md5($formData->new);
        $user->save();

        $log = $this->logsBO->store(['action' => 'update_user', 'data' => $user]);

        return [true, 'Password changed!'];
    }

    public function validPasswordReset ($userID) {

        if($userID == \Auth::user()->id)
            return [false, 'You can\'t reset your own password. Please, use change password action.'];

        $user = UsersBO::getUser(userID);

        if(!$user)
            return [false, 'User not found!'];

        $n = "1234567890";
        $password = substr(str_shuffle(str_shuffle($n)), 0, 8);

        $user->password = md5($password);
        $user->save();

        $email = $this->emailsBO->passwordReset($password, $user);

        $log = $this->logsBO->store(['action' => 'update_user', 'data' => $user]);

        return [true, 'Password reseted!'];
    }

    public function passwordChangeRequest ($email) {

        $user = UsersBO::getUserByEmail($email);

        if(!$user)
            return [false, 'This emails is not in our base. Are your sure it is your email?', $email];

        $hash = md5($user->id . time() * rand(0, 10000));

        $user->remember_token = $hash;
        $user->save();

        $email = $this->emailsBO->passwordRequest($hash, $user);

        $log = $this->logsBO->store(['action' => 'update_user', 'data' => $user]);

        return [true, 'An email was sent to your inbox, check it out to recover your password. TIP: you may need to look spam.'];
    }

    public function validatetoken ($token) {

        $user = User::where('remember_token', $token)
            ->active()
            ->first();

        if(!$user)
            return [false, 'Invalid token. Please, try password recovery.', ''];

        return [true, $user];
    }

    public function passwordReset ($request, $token) {

        if($request->password != $request->passwordrepeat)
            return [false, 'Different passwords! Please, fill both fields with the same password.'];

        $user = UsersBO::getUserByEmail($request->email);

        $user->password = md5($request->password);
        $user->remember_token = '';

        $user->save();

        $log = $this->logsBO->store(['action' => 'update_user', 'data' => $user]);

        return [true, 'Password changed! You may log in now with the new password.'];
    }

    public function update ($request, $id) {

        $user = UsersBO::getUser($id);

        if (!$user) {
            return [false, 'User not found.'];
        }

        if ($user->email != $request->email){
            $userEmail = UsersBO::getUserByEmail($request->email);
            if ($userEmail) {
                return [false, 'This email is own by another user.'];
            }
        }
        
        $data = $request->all();
        $user->update($data);

        $log = $this->logsBO->store(['action' => 'update_user', 'data' => $user]);

        return [true, 'Data updated.'];
    }

    public function statusChange ($type, $id) {

        if ($id == \Auth::user()->id) {
            return [false, 'You can\'t change your own status.'];
        }

        $status = 0;

        if ($type == 'delete') {
            $status = 2;
            $label = 'deleted';
        }
        if ($type == 'enable') {
            $status = 1;
            $label = 'deactivated';
        }
        if ($type == 'disable') {
            $status = 0;
            $label = 'activated';
        }

        $user = UsersBO::getUser($id);

        if (!$user)
            return [false, 'User not found.'];

        if ($type == 'delete') {
            $user->user_deleted = \Auth::user()->id;
            $user->deleted_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        $user->status = $status;
        $user->save();

        $log = $this->logsBO->store(['action' => 'update_user', 'data' => $user]);

        return [true, 'User ' . $label . '.'];
    }

    public function store ($request, $callback) {

        $user = UsersBO::getUserByEmail($request->email);

        if ($user) {
            return [false, 'This email is own by another user. Please, try another.'];
        }

        $n = "1234567890";
        $password = substr(str_shuffle(str_shuffle($n)), 0, 8);

        $user = User::create();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = 1;
        $user->type = $request->type;
        $user->password = md5($password);
        $user->created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $user->save();

        $email = $this->emailsBO->userCreate($password, $user);

        $log = $this->logsBO->store(['action' => 'create_user', 'data' => $user]);

        return [true, 'User updated.'];
    }
}