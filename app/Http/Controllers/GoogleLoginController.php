<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GoogleLoginController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirect()
    {
        $parameters = ['access_type' => 'offline', "prompt" => "consent select_account"];
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/forms'])
            ->with($parameters)// refresh token
            ->redirect();
    }

    public function callback()
    {
        $userInfo = Socialite::driver('google')->user();
        dd($userInfo);
    }
}
