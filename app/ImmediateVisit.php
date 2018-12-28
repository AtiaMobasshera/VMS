<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImmediateVisit extends Model
{
    public function admin()
    {
    	return $this->belongsTo('App\User', 'adminId', 'id');
    }
}
