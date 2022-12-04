<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::firstOrCreate([
                'email' => $googleUser->email
            ], [
                'email_verified_at' => now(),
                'google_id' => $googleUser->getId()
            ]);
            Auth::login($user, true);
            
            return redirect('/login_conf');
            

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
