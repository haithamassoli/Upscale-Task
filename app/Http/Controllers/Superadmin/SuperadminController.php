<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Superadmin;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{
    function create(Request $request){
          //Validate inputs
          $request->validate([
             'name'=>'required',
             'email'=>'required|email|unique:superadmins,email',
             'password'=>'required|min:5|max:30',
             'cpassword'=>'required|min:5|max:30|same:password'
          ]);

          $superadmin = new Superadmin();
          $superadmin->name = $request->name;
          $superadmin->email = $request->email;
          $superadmin->password = \Hash::make($request->password);
          $save = $superadmin->save();

          if( $save ){
              return redirect()->back()->with('success','You are now registered successfully as Superadmin');
          }else{
              return redirect()->back()->with('fail','Something went Wrong, failed to register');
          }
    }

    function check(Request $request){
        //Validate Inputs
        $request->validate([
           'email'=>'required|email|exists:superadmins,email',
           'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>'This email is not exists in superadmin table'
        ]);

        $creds = $request->only('email','password');

        if( Auth::guard('superadmin')->attempt($creds) ){
            return redirect()->route('superadmin.home');
        }else{
            return redirect()->route('superadmin.login')->with('fail','Incorrect Credentials');
        }
    }

    function logout(){
        Auth::guard('superadmin')->logout();
        return redirect('/');
    }
}
