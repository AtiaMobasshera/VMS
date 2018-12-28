<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    public function home()
    {
    	if(Auth::check())
    		return redirect()->route('dashboard');
    	else
    		return redirect()->route('login');
    }
}
