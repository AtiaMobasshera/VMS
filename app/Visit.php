<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
	public function admin()
	{
		return $this->belongsTo('App\User', 'adminId', 'id');
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
