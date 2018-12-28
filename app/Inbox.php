<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public function sender()
	{
		return $this->belongsTo('App\User', 'senderId', 'id');
	}

	public function receiver()
	{
		return $this->belongsTo('App\User', 'receiverId', 'id');
	}
}
