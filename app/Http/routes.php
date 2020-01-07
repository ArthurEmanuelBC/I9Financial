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

Route::get("auth/logout", function () {
	Auth::logout();
	return redirect('/');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
// Reset Password
Route::get('password/reset', 'Auth\PasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@showResetForm');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', 'IndexController@index');

	Route::resource("users","UserController");
	Route::get('user_verificar_password', 'UserController@verificar_senha');
	Route::get('user_verificar_login', 'UserController@verificar_login');

	Route::resource("pacientes","PacienteController");
	Route::resource("empresas","EmpresaController");
	Route::resource("contas","ContumController");
	Route::post("parcelas_pagar", ['as' => 'parcelas.pagar', 'uses' => 'ContumController@pagar']);

	Route::get('empresas/{id}/margem', 'EmpresaController@margem');
});

// Storage
Route::get('storage/{model}/{id}/{filename}', function ($model,$id,$filename){
	$path = storage_path("app/$model/$id/$filename");

	if (!File::exists($path))
		abort(404);

	$file = File::get($path);
	$type = File::mimeType($path);

	$response = Response::make($file, 200);
	$response->header("Content-Type", $type);
	return $response;
});
