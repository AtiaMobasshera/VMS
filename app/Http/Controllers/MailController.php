<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;
use Session;
use Exception;

class MailController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function send(Request $request, $id)
    {
    	$this->validate($request, array(
    		'subject' => 'required|min:5',
    		'body' => 'required|min:15'
		));

    	$user=User::find($id);

		$mailData=['from' => Auth::user()->email, 'to' => $user->email, 'name' => $user->name, 'subject' => $request->subject, 'body' => $request->body];

		try{
			Mail::send('emails.send', $mailData, function($mail) use($mailData){
				$mail->from($mailData['from']);
				$mail->to($mailData['to']);
				$mail->subject($mailData['subject']);
			});
			Session::flash('mailSent', 'Mail successfully sent to <b>'.$user->email.'</b>');
		}catch(Exception $e){
			Session::flash('mailNotSent', 'Mail sending unsuccessful to <b>'.$user->email.'</b>');
		}

		return redirect()->back();
    }
}
