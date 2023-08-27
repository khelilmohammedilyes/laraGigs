<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //register form
    public function create(){
        return view('users.register');
    }

    //store user
    public function store(Request $request){
        $validation=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>'required|confirmed|min:6'
        ]);

        //hash password
        $validation['password']=bcrypt($validation['password']);

        $user=User::create($validation);
        auth()->login($user);
        return redirect('/')->with('message','user created! you are in');
    }

    //logout
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','loged out!');
    }

    //login form
    public function login(){
        return view('users.login');
    }

    //autheticate user
    public function authenticate(Request $request){
        $validation=$request->validate([
            'email'=>['required','email'],
            'password'=>'required'
        ]);

        if(auth()->attempt($validation)){
            $request->session()->regenerate();
            return redirect('/')->with('message','logged in');
        }

        return back()->withErrors(['email'=>'invalid authentication'])->onlyInput('email');
    }
}
