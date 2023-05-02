<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class FacebookOauthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $returnedUser = Socialite::driver('facebook')->user();
        $user       =   User::where(['email' => $returnedUser->getEmail()])->first();
        if($user){
            if($user->provider_id == null){
                $user->provider_id = $returnedUser->getId();
                $user->provider = 'facebook';
                if($user->update()){
                    auth()->login($user,true);
                    return redirect('/');
                }else{
                    return redirect()->route('frontend.user.login.form')->with('error','failed to login. Try again.');
                }
            }
            if($user->provider_id == $returnedUser->getId()){
                auth()->login($user,true);
                return redirect('/');
            }else{
                return redirect()->route('frontend.user.login.form')->with('error','failed to login. Try again.');
            }
        }else{
            $user = User::create([
                'name'          => $returnedUser->getName(),
                'email'         => $returnedUser->getEmail(),
                'image'         => $returnedUser->getAvatar(),
                'provider_id'   => $returnedUser->getId(),
                'provider'      => 'facebook',
                'status' => true
            ]);
            Auth::login($user);
            session(['tab' => 'changePassword']);
            return redirect('/account');
        }
        
    }
}
