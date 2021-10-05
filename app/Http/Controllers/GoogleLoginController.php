<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    //

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    public function callback(Request $request)
    {
        try {
            $userInfo = Socialite::driver('google')->user();
            dump($userInfo);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
