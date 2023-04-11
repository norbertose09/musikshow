<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function dashboard(){
        $users = Payment::count();
        return view('pages.dashboard', [
            'userDatas' => Payment::latest()->filter(request(['search']))->get()
        ],
  compact('users')
);
    }

    public function signin(){
        return view('pages.login');
    }
    public function register(){
        return view('pages.register');
    }

    public function create(Request $request){
        $formData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
        $formData['password'] = bcrypt($formData['password']);
        $user = User::create($formData);
        auth()->login($user);

        return redirect('/admin/dashboard');
    }

    public function logout(Request $request){
        auth()->logout();

        //To invalidate session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
   
        return redirect('/admin/signin');
    }

    public function login(Request $request){
        $formField = $request->validate([
            'name' => ['required'],
            'password' => ['required']
          ]);
          if(auth()->attempt($formField)){
            $request->session()->regenerate();
    
            return redirect('/admin/dashboard');
        }
        return back()->withErrors(['name' => 'Invalid Credentials'])->onlyInput('name');

    }
}