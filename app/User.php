<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
    use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'users';
    protected $fillable = ['remember_token', 'name', 'email', 'password', 'type', 'status', 'street', 'number', 'complement', 'district', 'zipcode', 'city', 'state', 'phone'];
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'user_deleted', 'deleted_at'];

    public function logs () {
        return $this->hasMany('\App\Logs', 'user_id');
    }

    public function scopeMine ($query) {
        return $query->where('id', \Auth::user()->id);
    }

    public function scopeActive ($query) {
        return $query->where('users.status', '1');
    }
}
