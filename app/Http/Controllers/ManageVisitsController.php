<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use Auth;
use Mail;
use Exception;

class ManageVisitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\AdminMiddleware');
    }

    public function index()
    {
        $visits=Visit::where('adminId', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('managevisits.index')->withVisits($visits);
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

        $visit=Visit::find($id);
        $visit->status=(int)$request->status;

        if($request->status=='1')
            $visit->code=$this->randomCode();
        $visit->save();

        if($request->status=='1'){
            $mailData=['from' => Auth::user()->email, 'to' => $visit->visitor->email, 'id' => $id];

            try{
                Mail::send('emails.visitRequestAccepted', $mailData, function($mail) use($mailData){
                    $mail->from($mailData['from']);
                    $mail->to($mailData['to']);
                    $mail->subject('VMS: Visit Request');
                });
            }catch(Exception $e){
                //
            }
        }
        else if($request->status=='-1'){
            $mailData=['from' => Auth::user()->email, 'to' => $visit->visitor->email, 'id' => $id];

            try{
                Mail::send('emails.visitRequestRejected', $mailData, function($mail) use($mailData){
                    $mail->from($mailData['from']);
                    $mail->to($mailData['to']);
                    $mail->subject('VMS: Visit Request');
                });
            }catch(Exception $e){
                //
            }
        }

        return redirect()->route('managevisits.index');
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
        return redirect()->route('managevisits.index');
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
        $visits=Visit::where([['adminId', '=', Auth::user()->id], ['status', '=', 1]])->orderBy('id', 'DESC')->get();
        return view('managevisits.approved')->withVisits($visits);
    }

    public function pending(){
        $visits=Visit::where([['adminId', '=', Auth::user()->id], ['status', '=', 0]])->orderBy('id', 'DESC')->get();
        return view('managevisits.pending')->withVisits($visits);
    }

    public function rejected(){
        $visits=Visit::where([['adminId', '=', Auth::user()->id], ['status', '=', -1]])->orderBy('id', 'DESC')->get();
        return view('managevisits.rejected')->withVisits($visits);
    }
}
