<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use Image;
use Auth;
use File;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id);
        $profile=Profile::where('userId', $id)->first();

        if(!empty($user) && !empty($profile))
            return view('profiles.show')->withUser($user)->withProfile($profile);
        else if(!empty($user) && empty($profile))
            return view('profiles.show')->withUser($user);
        else
            return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id!=$id)
            return abort(403);
        else{
            $profile=Profile::where('userId', $id)->first();

            if(!empty($profile))
                return view('profiles.edit')->withProfile($profile);
            else
                return view('profiles.edit');
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
            'name' => 'required|string|min:5|max:255',
            'phone' => 'required|numeric|min:5',
            'address' => 'required|min:5',
            'occupation' => 'required|min:3',
            'avatar' => 'image|mimes:jpeg,jpg,png|max:2560',
            'about' => 'required|min:5'
        ));

        $user=User::find($id);
        $user->name=ucwords($request->name);
        $user->save();

        $profile=Profile::where('userId', $id)->first();
        if(empty($profile)){
            $prf=new Profile();
            $prf->userId=Auth::user()->id;
            $prf->phone=$request->phone;
            $prf->address=$request->address;
            $prf->occupation=$request->occupation;

            if($request->hasFile('avatar')){
                $avatar=$request->file('avatar');
                $filename=Auth::user()->id.'_'.time().'.'.$avatar->getClientOriginalExtension();
                $location=public_path('images/avatar/'.$filename);
                Image::make($avatar)->resize(400, 400)->save($location);

                $prf->avatar=$filename;
            }

            $prf->about=$request->about;
            $prf->save();
        }
        else{
            $profile->phone=$request->phone;
            $profile->address=$request->address;
            $profile->occupation=$request->occupation;

            if($request->hasFile('avatar')){
                $delPrev=public_path().'/images/avatar/'.$profile->avatar;
                if(file_exists($delPrev))
                    File::Delete($delPrev);

                $avatar=$request->file('avatar');
                $filename=Auth::user()->id.'_'.time().'.'.$avatar->getClientOriginalExtension();
                $location=public_path('images/avatar/'.$filename);
                Image::make($avatar)->resize(400, 400)->save($location);

                $profile->avatar=$filename;
            }

            $profile->about=$request->about;
            $profile->save();
        }

        return redirect()->route('profiles.show', Auth::user()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
