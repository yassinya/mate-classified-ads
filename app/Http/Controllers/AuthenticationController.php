<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');

        // validate user inputs
        $validator = $this->validator($credentials);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // attempt to log in the user using the given credentials
        if($this->logUserIn($credentials)){
            // if successfully logged in, redirect the user to their intended page 
            return redirect()->intended('/');
        }

        // otherwise return error message
        return redirect()->back()
                         ->withInput($req->except('password'))
                         ->withErrors([
                             'The email address or password is incorrect. Please retry.'
                         ]);

    }

    protected function validator(array $data){
        return Validator::make($data, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
    }

    protected function logUserIn(array $credentials){
        return Auth::guard('web')->attempt($credentials);
    }
}
