<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
use App\Providers\RouteServiceProvider;
class SocialController extends Controller
{
	public function redirect($provider)
	{
	    return Socialite::driver($provider)->redirect();
	}
 
	public function callback($provider)
	{
	           
	    $getInfo = Socialite::driver($provider)->user();
	     
	    $user = $this->createUser($getInfo,$provider);
	 
	    auth()->login($user);
	 
	    return redirect()->to(RouteServiceProvider::HOME);
	 
	}
	function createUser($getInfo,$provider){
	 
		$user = User::where('provider_id', $getInfo->id)
						->orWhere('email', $getInfo->email)
						->first();
		// dd($getInfo->avatar);	 
		if (!$user) {
			$user = User::create([
				'name'     => $getInfo->name,
				'avatar'   => $getInfo->avatar,
				'email'    => $getInfo->email,
				'provider' => $provider,
				'provider_id' => $getInfo->id,
				'password' => bcrypt('123456789')
			]);
		}
		return $user;
	}
}