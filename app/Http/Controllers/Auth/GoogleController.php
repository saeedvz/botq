<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function redirectToProvider(Request $request)
    {
        if ($request->server('HTTP_REFERER')) {
            $request->session()->put('request_uri', $request->server('HTTP_REFERER'));
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $authUser = Socialite::driver('google')->user();

            if ($authUser && $authUser->email) {
                $user = User::where('email', '=', $authUser->email)->where('status', '=', 1)->first();
                if (!$user) {
                    $user = User::create([
                        'name'              => $authUser->name,
                        'email'             => $authUser->email,
                        'password'          => 'not_set',
                        'email_verified_at' => date('Y-m-d H:i:s')
                    ]);
                }
                Auth::login($user);
            }

            if ($request->session()->has('request_uri')) {
                return redirect($request->session()->get('request_uri'));
            }

            return redirect('/');
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }
}
