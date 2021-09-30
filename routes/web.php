<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\BoardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('boards', BoardController::class);

Route::view('home', 'home')->middleware('auth');

//이유는 모르겠지만 Route::view()에서는 이름이 지정되지 않는다. 따로 체인메서드로 name('라우트명')으로 이름을 지정해줘야한다.
Route::view('profile/edit', 'profile.edit')->name('profile.edit')->middleware('auth');

Route::view('profile/password/edit', 'profile.password.edit')->name('profile.password.edit')->middleware('auth');  //컨벤션 질문 passwordEdit
