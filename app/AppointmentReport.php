<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentReport extends Model
{
    public function appointment()
	{
		return $this->belongsTo('App\Appointment', 'appointmentId', 'id');
	}
}
