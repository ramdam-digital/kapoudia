<?php

class User_Controller extends Base_Controller {

	function get_login() {
		if(!Auth::guest()){
			return Redirect::to_route('admin');
		}

    	return View::make('layouts.login');
	}

	function post_access() {
	    $username = Input::get('username');
	    $password = Input::get('password');
	    if ( Auth::attempt(array('username' => $username, 'password' => $password)) )
	    {
	        return Redirect::to_route('admin');
	    }
	    else
	    {
	        return Redirect::to_route('login')
	            ->with('login_errors', true);
	    }
	}

	function get_logout() {
	    Auth::logout();
	    return Redirect::to_route('login');
	}

	public function get_manager(){
		$lang = Config::get('application.language');
		$users = User::where('role', '!=', 2)->order_by('username')->get();
		return View::make('user.manager')->with('users', $users);
	}

	public function get_delete($id){
		DB::table('users')->where_id($id)->delete();
		return Redirect::to_route('manage_user')
						->with('message', 'Utilisateur supprimé avec succès!');
	}

	public function put_change(){
		$pros = Input::get('pro');
		if(count($pros)<=0){
			return Redirect::to_route('manage_user');
		}else{
			foreach ($pros as $key => $value) {
				$user = User::find($key);
				if(!is_null($user)){
					$user->role = $value;
					$user->save();
				}
			}

			return Redirect::to_route('manage_user')
							->with('message', 'Les profils sont modifiés avec succès!');

		}
	}
}