<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $req)
    {
        // set validation rules for user inputs
        $validator = $this->validator($req->all());

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // create the user
        $user = $this->createUser($req->all());
        // find & associate previously posted ads as guest by this user
        $this->linkUserToAds($user);

        // dispatch event to send verification email etc
        // TODO

        // login the newly created user
        Auth::login($user);

        return redirect()->back();
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone_number' => ['string', 'max:255'],
        ]);
    }

    protected function createUser(array $data){
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function linkUserToAds(User $user){

        // get ads which have this user's email AND haven't been assigned to a user yet
        $userAds = Ad::whereEmail($user->email)->whereNull('user_id')->get();

        if(! $userAds){
            return;
        }

        foreach ($userAds as $ad) {
            $ad->user()->associate($user);
            $ad->save();
        }
    }

}
