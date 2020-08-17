<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        if(Auth::user()->id == $id){
            $user = User::find($id);
            return view('profile.show')->with('user', $user);
        }
        
        return redirect('/');
        
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
        if(Auth::user()->id == $id){
            $message = "";

            if($request->has(['name'])){
                $request->validate([
                    'name' => ['required', 'string', 'min:3', 'max:255'],
                    ]);

                $user = User::find($id);
                $user->name = $request->name;
                $user->save();
                $message = "Name Changed Successfully";
            }

            else if($request->has(['email'])){
                $request->validate([
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
                ]);

                $user = User::find($id);
                $user->email = $request->email;
                $user->save();
                $message = "Email Changed Successfully";
            }

            else if($request->has(['gender'])){
                $request->validate([
                    'gender' => ['required', 'string', 'min:4', 'max:6'],
                    ]);

                $user = User::find($id);
                $user->gender = $request->gender;
                $user->save();
                $message = "Gender Changed Successfully";
            }

            else if($request->has(['date_of_birth'])){
                $request->validate([
                    'date_of_birth' => ['required', 'date', 'before:today'],
                    ]);

                $user = User::find($id);
                $user->date_of_birth = $request->date_of_birth;
                $user->save();
                $message = "Date of Birth Changed Successfully";
            }

            else if($request->has(['opassword', 'npassword', 'cpassword'])){
                $user = User::find($id);
                if(Hash::check($request->opassword, $user->password)){
                    //validate the new passwords
                    if($request->validate([
                        'npassword' => ['required', 'string', 'min:8'],
                        'cpassword' => ['required', 'same:npassword']
                    ])){
                        $user->password = Hash::make($request->npassword);
                        $user->save();
                        $message = "Password Changed successfully";
                    }
                    else {
                        $message = "Your New Passwords Mismatch";
                    }
                }
                else{
                    $message = "Incorrect Password";
                }

            }
        }
        return back();
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
