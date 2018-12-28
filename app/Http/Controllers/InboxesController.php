<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Inbox;
use Session;

class InboxesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$messages=Inbox::where('receiverId', Auth::user()->id)->orderBy('id', 'DESC')->get();
    	return view('inboxes.index')->withMessages($messages);
    }

    public function store(Request $request, $id)
    {
    	$this->validate($request, array(
    		'message' => 'required'
		));

		$inbox=new Inbox();
		$inbox->senderId=Auth::user()->id;
		$inbox->receiverId=$id;
		$inbox->message=$request->message;
		$inbox->save();

		Session::flash('messageSent', 'Message Sent');
		return redirect()->back();
    }
}
