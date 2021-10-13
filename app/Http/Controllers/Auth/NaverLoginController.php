<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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


        //Log the user in

        // Redirect to dashboard
        try {
            // Create a new user in our database
            $user = Socialite::driver('naver')->user();
            $finduser = User::where('social_id', $user->getId())->first();
            $existingUser = User::where('email', $user->getEmail())->first();

            $id = $user->user['response']['id'];
            $name = $user->user['response']['name'];
            $social_type = 'naver';

            if (!$finduser) {
                if (!$existingUser) {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => now(),
                        'social_id' => $user->id,
                        'social_type' => 'naver',
                    ]);

                    Auth::login($newUser);

                    return redirect('/home');
                } else {
                    //소셜로그인한 email주소가 기존 사용자의 email주소와 일치할 경우

                    return redirect()->route('socialogin.receive', compact('id', 'name', 'social_type'));
                }
            } else {
                // Auth::login($finduser);
                auth()->login($finduser, true);

                return redirect('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function receiveEmail(Request $request)
    {
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'social_id' => $request->id,
            'social_type' => 'naver',
        ]);

        Auth::login($newUser);

        return redirect('/home');
    }
}
