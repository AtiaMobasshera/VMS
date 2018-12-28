<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitReport extends Model
{
    public function visit()
	{
		return $this->belongsTo('App\Visit', 'visitId', 'id');
	}
}
