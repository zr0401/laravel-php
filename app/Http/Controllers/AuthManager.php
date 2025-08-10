<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthManager extends Controller
{
    //
    function login() {
        return view('login');
    }

    function registration() {
        return view('registration');
    }

    function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if(!$user){
            Log::error("Incorrect email for " . $request->email);
            return redirect(route('login'))->with("error", "Login Details are incorrect");
        }

        if(!Hash::check($password, $user->password)){
            Log::error("Incorrect password for " . $request->email);
            return redirect(route('login'))->with("error", "Login Details are incorrect");
        }
        else{
            Auth::login($user);
            Log::info("User " . $request->email . " logged in successfully.");
            return redirect()->intended(route('welcome'))->with("success", "Login Successful");
        }
    }

    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        // Handle registration logic here
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user) {
            return redirect(route('registration'))->with("error", "Registration failed");
        }
        return redirect(route('login'))->with("success", "Registration successful, please login");
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}