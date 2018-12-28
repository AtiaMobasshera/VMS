<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Reason;
use Auth;
use App\User;
use Session;
use App\Visit;
use Mail;
use Exception;

class VisitsController extends Controller
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
        $this->middleware('App\Http\Middleware\AdminVisitorMiddleware', ['only' => 'show']);
    }

    public function index()
    {
        $visits=Visit::where('visitorId', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('visits.index')->withVisits($visits);
    }

    public function approved()
    {
        $visits=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', 1]])->orderBy('id', 'DESC')->get();
        return view('visits.approved')->withVisits($visits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reasons=Reason::orderBy('name', 'ASC')->get();
        // $picked=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', 1]])->get();
        return view('visits.create')->withReasons($reasons);
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
            'reasonId' => 'required',
            'purpose' => 'required|min:20',
            'vTime' => 'required',
            'vTime' => 'required'
        ));

        $visitorId=Auth::user()->id;
        $admin=User::where('role', 'admin')->first();

        $dateVal=Visit::where([['visitorId', '=', $visitorId], ['adminId', '=', $admin->id], ['vDate', '=', $request->vDate], ['vTime', '=', strtoupper($request->vTime)]])->first();

        if(empty($dateVal)){
            $visit=new Visit();
            $visit->visitorId=$visitorId;
            $visit->adminId=$admin->id;
            $visit->reasonId=$request->reasonId;
            $visit->purpose=ucfirst($request->purpose);
            $visit->vDate=$request->vDate;
            $visit->vTime=strtoupper($request->vTime);
            $visit->save();

            $mailData=['from' => Auth::user()->email, 'to' => $admin->email, 'id' => $visit->id];
            $exp='';

            try{
                Mail::send('emails.visitRequest', $mailData, function($mail) use($mailData){
                    $mail->from($mailData['from']);
                    $mail->to($mailData['to']);
                    $mail->subject('VMS: Visit Request');
                });
            }catch(Exception $e){
                $exp=' Mail could not send!';
            }

            Session::flash('visitRequestSent', 'Your request is sent to admin. Wait for approval!'.$exp);
            return redirect()->route('visits.show', $visit->id);
        }
        else{
            Session::flash('visitRequestNotSent', 'You are already requested in this visit schedule <b>'.$request->vDate.' '.$request->vTime.'</b>');
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
        $visit=Visit::find($id);
        
        if(empty($visit))
            return abort(404);
        else{
            if(Auth::user()->id==$visit->visitorId || Auth::user()->id==$visit->adminId){
                return view('visits.show')->withVisit($visit);
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
        $visit=Visit::find($id);

        if(empty($visit)){
            return abort(404);
        }
        else{
            if(Auth::user()->id==$visit->visitorId){
                if($visit->status==0){
                    $reasons=Reason::orderBy('name', 'ASC')->get();
                    return view('visits.edit')->withReasons($reasons)->withVisit($visit);
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
        $admin=User::select('id')->where('role', 'admin')->first();

        $visit=Visit::find($id);
        $visit->visitorId=$visitorId;
        $visit->adminId=$admin->id;
        $visit->reasonId=$request->reasonId;
        $visit->purpose=ucfirst($request->purpose);
        $visit->vDate=$request->vDate;
        $visit->vTime=$request->vTime;
        $visit->save();

        Session::flash('visitUpdateSuccess', 'Your request is sent to admin. Wait for approval!');
        return redirect()->route('visits.show', $visit->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visit=Visit::find($id);
        $visit->delete();
        return redirect()->route('visits.index');
    }

    public function pending(){
        $visits=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', 0]])->orderBy('id', 'DESC')->get();
        return view('visits.pending')->withVisits($visits);
    }

    public function rejected(){
        $visits=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', -1]])->orderBy('id', 'DESC')->get();
        return view('visits.rejected')->withVisits($visits);
    }
}
