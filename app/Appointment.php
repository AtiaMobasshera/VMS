<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function host()
	{
		return $this->belongsTo('App\User', 'hostId', 'id');
	}

	public function visitor()
	{
		return $this->belongsTo('App\User', 'visitorId', 'id');
	}

    public function reason()
    {
    	return $this->belongsTo('App\Reason', 'reasonId', 'id');
    }
}
