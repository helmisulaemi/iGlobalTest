<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'usergroup'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // relation one to one
    public function phone()
    {
        // dimana 1 user hanya boleh memiliki 1 phone begitu sebaliknya
        return $this->hasOne('App\Phone');
    }


    // relation one to many
    public function postings()
    {
        // dimana 1 user boleh memposting banyak data
        // namun 1 posting harus dimiliki oleh 1 user
        return $this->hasMany('App\Posting');
    }


    // relation many to many
    public function roles()
    {
        // dimana 1 user boleh memiliki banyak role begitu sebaliknya
        // 1 role boleh memiliki banyak user
        return $this->belongsToMany('App\Role');
    }
}
