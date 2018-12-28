<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostsDesignation extends Model
{
	public function users()
	{
	    return $this->hasMany('App\User', 'hostId', 'id');
	}

	public function designation()
	{
		return $this->belongsTo('App\Designation', 'designationId', 'id');
	}
}
