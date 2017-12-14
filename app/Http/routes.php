<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('login', function()
{
  return view('login');
});
Route::post('login',function(){
	$rules = array(
		'email' =>'required|email',
		'password' =>'required|min:6',
		'remember_me' =>'boolean',
	);
	$validator = Validator::make(Request::all(),$rules);
	if($validator->passes()){
		if(Auth::attempt([
			'email' => Request::input('email'),
			'password' => Request::input('password'),
			'block' =>0
		],
		(boolean) Request::input('remember_me')))
	{
		return Redirect::to('home');
	}
	else{
		return Redirect::to('login')->withInput()->with('message',array('type'=>'danger','content'=>'E-mail or password error'));
	}
	}
	else{
		return Redirect::to('login')->withInput()->withErrors($validator);
	}
});
Route::get('home',['middleware'=> 'auth' , function(){
	return view('home');
}]);
Route::get('logout',['middleware'=>'auth',function(){
	Auth::logout();
	return Redirect::to('/');
}]);
Route::get('register',function(){
	return view('users.create');
});
Route::post('register',function(){
	$rules = [
		'email' =>'required|email|unique:users,email',
		'nickname'=>'required|min:4|unique:users,nickname',
		'password'=>'required|min:6|confirmed',
	];
	$validator = Validator::make(Request::all(),$rules);
	if ($validator->passes())
	  {
	    $user = new App\User();
	    $user->email = Request::input('email');
	    $user->nickname = Request::input('nickname');
	    $user->password = Hash::make(Request::input('password'));
	    if ($user->save())
	    {
	      return Redirect::to('login')->with('message', array('type' => 'success', 'content' => 'Register successfully, please login'));
	    } else {
	      return Redirect::to('register')->withInput()->with('message', array('type' => 'danger', 'content' => 'Register failed'));
	    }
	} else {
		return Redirect::to('register')->withInput()->withErrors($validator);
	}
});
Route::get('user/{id}/edit', ['middleware' => 'auth', 'as' => 'user.edit', function($id)
{    
  //????????????????????
    if (Auth::user()->is_admin or Auth::id() == $id) {
        return view('users.edit')->with('user', App\User::find($id));
    } else {
     //???????
        return Redirect::to('/');
    }
}]);

//???????
Route::post('user/{id}', ['middleware' => 'auth', function($id)
{
  if (Auth::user()->is_admin or (Auth::id() == $id)) {
    $user = App\User::find($id);
    //??????
    $rules = array(
      'password' => 'required_with:old_password|min:6|confirmed',
      'old_password' => 'min:6',
    );
    if (!(Input::get('nickname') == $user->nickname))
    {
      $rules['nickname'] = 'required|min:4||unique:users,nickname';
    }
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->passes())
    {
      if (!(Input::get('old_password') == '')) {
        if (!Hash::check(Input::get('old_password'), $user->password)) {
          return Redirect::route('user.edit', $id)->with('user', $user)->with('message', array('type' => 'danger', 'content' => 'Old password error'));
        } else {
          $user->password = Hash::make(Input::get('password'));
        }
      }
      $user->nickname = Input::get('nickname');
      $user->save();
      //????????
      return Redirect::route('user.edit', $id)->with('user', $user)->with('message', array('type' => 'success', 'content' => 'Modify successfully'));
    } else {
      //??????
      return Redirect::route('user.edit', $id)->withInput()->with('user', $user)->withErrors($validator); 
    }
  } else {
    return Redirect::to('/');
  }
}]);

Route::group(['prefix' => 'admin', 'middleware' => ['auth','isAdmin']], function()
{
  //??????
  Route::get('users', function()
  {
    return view('admin.users.list')->with('users', App\User::all())->with('page', 'users');
  });
});

//Route group:has login and admin
Route::group(['middleware' => ['auth','isAdmin']], function()
{
  //psw reset
  Route::get('user/{user}/reset', function(App\User $user)
  {
    $user->password = Hash::make('123456');
    $user->save();
    return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => 'Reset password successfully'));
  });
    //lock user
  Route::get('user/{user}/delete', function(App\User $user)
  {
    $user->block = 1;
    $user->save();
    return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => 'Lock user successfully'));
  });
//unlock user
  Route::get('user/{user}/unblock', function(App\User $user)
  {
    $user->block = 0;
    $user->save();
    return Redirect::to('admin/users')->with('message', array('type' => 'success', 'content' => 'Unlock user successfully'));
  });
});
Route::post('article/preview',['middleware'=>'auth','uses'=>'ArticleController@preview']);
Route::resource('article','ArticleController');
