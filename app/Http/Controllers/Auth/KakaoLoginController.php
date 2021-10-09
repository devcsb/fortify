<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class KakaoLoginController extends Controller
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
        return Socialite::driver('kakao')->redirect();
    }

    public function callback()
    {
        
        
        //Log the user in

        // Redirect to dashboard
        try {
            // Create a new user in our database
            $user = Socialite::driver('kakao')->user();
      
            $finduser = User::where('social_id', $user->id)->first();
            if (!$finduser) {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => now(),
                    'social_id'=> $user->id,
                    'social_type'=> 'kakao',
                ]);
     
                Auth::login($newUser);
      
                return redirect('/home');
            } else {
                // Auth::login($finduser);
                auth()->login($finduser, true);
                     
                return redirect('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
