<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use Auth;
use Mail;
use Exception;

class ManageAppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\HostMiddleware');
    }

    public function index()
    {
        $appointments=Appointment::where('hostId', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('manageappointments.index')->withAppointments($appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'status' => 'required'
        ));

        $appointment=Appointment::find($id);
        $appointment->status=(int)$request->status;

        if($request->status=='1')
            $appointment->code=$this->randomCode();
        $appointment->save();

        if($request->status=='1'){
            $mailData=['from' => Auth::user()->email, 'to' => $appointment->visitor->email, 'id' => $id];

            try{
                Mail::send('emails.appointmentRequestAccepted', $mailData, function($mail) use($mailData){
                    $mail->from($mailData['from']);
                    $mail->to($mailData['to']);
                    $mail->subject('VMS: Appointment Request');
                });
            }catch(Exception $e){
                //
            }
        }
        else if($request->status=='-1'){
            $mailData=['from' => Auth::user()->email, 'to' => $appointment->visitor->email, 'id' => $id];

            try{
                Mail::send('emails.appointmentRequestRejected', $mailData, function($mail) use($mailData){
                    $mail->from($mailData['from']);
                    $mail->to($mailData['to']);
                    $mail->subject('VMS: Appointment Request');
                });
            }catch(Exception $e){
                //
            }
        }

        return redirect()->route('manageappointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment=Appointment::find($id);
        $appointment->delete();
        return redirect()->route('manageappointments.index');
    }

    // Custom Access code generator method
    private function randomCode(){
        $alphabet='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $code=array();
        $alphaLength=strlen($alphabet)-1;
        for($i=0; $i<8; $i++){
            $n=rand(0, $alphaLength);
            $code[]=$alphabet[$n];
        }
        return implode($code);
    }

    public function approved(){
        $appointments=Appointment::where([['hostId', '=', Auth::user()->id], ['status', '=', 1]])->orderBy('id', 'DESC')->get();
        return view('manageappointments.approved')->withAppointments($appointments);
    }

    public function pending(){
        $appointments=Appointment::where([['hostId', '=', Auth::user()->id], ['status', '=', 0]])->orderBy('id', 'DESC')->get();
        return view('manageappointments.pending')->withAppointments($appointments);
    }

    public function rejected(){
        $appointments=Appointment::where([['hostId', '=', Auth::user()->id], ['status', '=', -1]])->orderBy('id', 'DESC')->get();
        return view('manageappointments.rejected')->withAppointments($appointments);
    }
}
