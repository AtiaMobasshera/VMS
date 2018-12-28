<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Reason;
use App\User;
use App\Appointment;
use Auth;
use Session;
use Mail;
use Exception;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\VisitorMiddleware', ['except' => 'show']);
        $this->middleware('App\Http\Middleware\HostVisitorMiddleware', ['only' => 'show']);
    }

    public function index()
    {
        $appointments=Appointment::where('visitorId', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('appointments.index')->withAppointments($appointments);
    }

    public function approved()
    {
        $appointments=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', 1]])->orderBy('id', 'DESC')->get();
        return view('appointments.approved')->withAppointments($appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hosts=User::where('role', 'host')->get();
        $reasons=Reason::orderBy('name', 'ASC')->get();
        $picked=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', 1]])->get();
        return view('appointments.create')->withReasons($reasons)->withHosts($hosts)->withPicked($picked);
    }

    public function specific($id)
    {
        $host=User::find($id);

        if(!empty($host) && $host->role=='host'){
            $hosts=User::where('role', 'host')->get();
            $reasons=Reason::orderBy('name', 'ASC')->get();
            return view('appointments.specific')->withReasons($reasons)->withHosts($hosts)->withHst($id);
        }
        else
            return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'hostId' => 'required',
            'reasonId' => 'required',
            'purpose' => 'required|min:20',
            'vTime' => 'required',
            'vTime' => 'required'
        ));

        $visitorId=Auth::user()->id;

        $dateVal1=Appointment::where([['visitorId', '=', $visitorId], ['hostId', '=', $request->hostId], ['vDate', '=', $request->vDate], ['vTime', '=', strtoupper($request->vTime)]])->first();
        $dateVal2=Appointment::where([['hostId', '=', $request->hostId], ['vDate', '=', $request->vDate], ['vTime', '=', strtoupper($request->vTime)], ['status', '=', 1]])->first();

        if(empty($dateVal1) && empty($dateVal2)){
            $appointment=new Appointment();
            $appointment->visitorId=$visitorId;
            $appointment->hostId=$request->hostId;
            $appointment->reasonId=$request->reasonId;
            $appointment->purpose=ucfirst($request->purpose);
            $appointment->vDate=$request->vDate;
            $appointment->vTime=strtoupper($request->vTime);
            $appointment->save();

            $mailData=['from' => Auth::user()->email, 'to' => $appointment->host->email, 'id' => $appointment->id];
            $exp='';

            try{
            Mail::send('emails.appointmentRequest', $mailData, function($mail) use($mailData){
                $mail->from($mailData['from']);
                $mail->to($mailData['to']);
                $mail->subject('VMS: Appointment Request');
            });
            }catch(Exception $e){
                $exp=' Mail could not send!';
            }

            Session::flash('appointmentRequestSent', 'Your request is sent to host. Wait for approval!'.$exp);
            return redirect()->route('appointments.show', $appointment->id);
        }
        else{
            $msg='';
            if(!empty($dateVal1) && !empty($dateVal2)){
                $msg='You already requested in this schedule <b>'.$request->vDate.' '.$request->vTime.'</b>';
                $msg.='<br>'.'Host is not free in this schedule <b>'.$request->vDate.' '.$request->vTime.'</b>';
            }
            else if(!empty($dateVal1) && empty($dateVal2))
                $msg='You already requested in this schedule <b>'.$request->vDate.' '.$request->vTime.'</b>';
            else if(empty($dateVal1) && !empty($dateVal2))
                $msg='Host is not free in this schedule <b>'.$request->vDate.' '.$request->vTime.'</b>';

            Session::flash('appointmentRequestNotSent', $msg);
            return redirect()->back()->withInput(Input::all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment=Appointment::find($id);
        
        if(empty($appointment))
            return abort(404);
        else{
            if(Auth::user()->id==$appointment->visitorId || Auth::user()->id==$appointment->hostId){
                return view('appointments.show')->withAppointment($appointment);
            }
            else
                return abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment=Appointment::find($id);

        if(empty($appointment)){
            return abort(404);
        }
        else{
            if(Auth::user()->id==$appointment->visitorId){
                if($appointment->status==0){
                    $hosts=User::where('role', 'host')->get();
                    $reasons=Reason::orderBy('name', 'ASC')->get();
                    return view('appointments.edit')->withReasons($reasons)->withHosts($hosts)->withAppointment($appointment);
                }
                else
                    return redirect()->back();
            }
            else
                return abort(403);
        }
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
            'reasonId' => 'required',
            'purpose' => 'required|min:20',
            'vTime' => 'required',
            'vTime' => 'required'
        ));

        $visitorId=Auth::user()->id;

        $appointment=Appointment::find($id);
        $appointment->visitorId=$visitorId;
        $appointment->reasonId=$request->reasonId;
        $appointment->purpose=ucfirst($request->purpose);
        $appointment->vDate=$request->vDate;
        $appointment->vTime=$request->vTime;
        $appointment->save();

        Session::flash('appointmentUpdateSuccess', 'Your request is sent to host. Wait for approval!');
        return redirect()->route('appointments.show', $appointment->id);
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
        return redirect()->route('appointments.index');
    }

    public function pending(){
        $appointments=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', 0]])->orderBy('id', 'DESC')->get();
        return view('appointments.pending')->withAppointments($appointments);
    }

    public function rejected(){
        $appointments=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', -1]])->orderBy('id', 'DESC')->get();
        return view('appointments.rejected')->withAppointments($appointments);
    }
}
