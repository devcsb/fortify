<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NaverLoginController extends Controller
{
    

    /**
     * 주어진 provider에 대하여 소셜 응답을 처리합니다.
     *
     * @param Request $request
     * @param string  $provider
     * @return RedirectResponse|Response
     */

    public function redirect()
    {
        return Socialite::driver('naver')->redirect();
    }

    public function callback()
    {
        $userInfo = Socialite::driver('naver')->user();
        dd($userInfo);
    }
}
