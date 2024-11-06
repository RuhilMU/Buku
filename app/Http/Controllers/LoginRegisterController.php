<?php

namespace App\Http\Controllers\Auth;

use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginRegisterController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]); 
    }

    public function register(){
        return view('auth.register');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->withSuccess('You have successfully registered & logged in!');
    }
    
    public function login(){
        return view(auth.login);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dashboard')
            ->withSuccess('Logged In.');
        }
        return back()->withErrors([
            'email' => 'Email/Password Tidak Sesuai.',
        ])->onlyInput('email');
    }

    public function dashboard(){
        if(Auth::check()){
            return view('auth.dashboard');
        }
        return redirect()->route('login')->withErrors([
            'email' => 'Email/Password Salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenrateToken();
        return redirect()->route('login')
        ->withSuccess( 'Logged Out.');
    }
}