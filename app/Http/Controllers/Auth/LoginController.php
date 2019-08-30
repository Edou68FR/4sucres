<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Throttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'email'                => ['required', 'email', new Throttle(__METHOD__, 5, 1)],
            'password'             => 'required',
            // 'g-recaptcha-response' => ['required', 'captcha'],
        ]);
        $validator->validate();

        $remember = $request->remember ?? false;

        if (auth()->once([
            'email' => request()->email,
            'password' => request()->password,
        ], $remember) && !user()->deleted_at) {
            if (user()->isBanned()) {
                $error = 'Le compte est banni ';
                $latest_ban = user()->bans->first();

                ($latest_ban->isPermanent()) ? $error .= 'définitivement' : 'jusqu\'au ' . $latest_ban->expired_at->format('d/m/Y à H:i');
                ($latest_ban->comment) ? $error .= ' (' . $latest_ban->comment . ').' : '.';

                $validator->errors()->add('password', $error);

                return response(['errors' => $validator->errors()], 422);
            }

            if (user()->getSetting('google_2fa.enabled', false)) {
                $validator = Validator::make($request->input(), ['one_time_password' => 'required']);
                $validator->validate();

                $google2fa = app('pragmarx.google2fa');

                if (!$google2fa->verifyKey(
                    decrypt(user()->getSetting('google_2fa.secret')),
                    request()->one_time_password
                )) {
                    $validator->errors()->add('one_time_password', 'Le code OTP est incorrect.');

                    activity()
                        ->causedBy(user())
                        ->withProperties([
                            'level'  => 'warning',
                            'method' => __METHOD__,
                        ])
                        ->log('LoginOTPFailed');

                    return response(['errors' => $validator->errors()], 422);
                }
            }

            auth()->loginUsingId(user()->id);

            activity()
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'info',
                    'method' => __METHOD__,
                ])
                ->log('LoginSuccessful');

            return response()->json(['intended_url' => session()->pull('url.intended', route('home'))]);
        } else {
            $validator->errors()->add('password', 'Le mot de passe est incorrect.');

            activity()
                ->withProperties([
                    'level'    => 'warning',
                    'method'   => __METHOD__,
                    'email'    => request()->email,
                ])
                ->log('LoginFailed');

            return response(['errors' => $validator->errors()], 422);
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
