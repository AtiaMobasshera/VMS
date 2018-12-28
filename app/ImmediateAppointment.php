<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImmediateAppointment extends Model
{
    public function host()
    {
    	return $this->belongsTo('App\User', 'hostId', 'id');
    }
}
