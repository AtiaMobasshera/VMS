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
        'name', 'email', 'role', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    // Host Designation model relation
    public function hostDesignation()
    {
        return $this->belongsTo('App\HostsDesignation', 'id', 'hostId');
    }

    // Assigned Profile model
    public function profile()
    {
        return $this->belongsTo('App\Profile', 'id', 'userId');
    }
}
