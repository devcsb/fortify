<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\WorknetController;
use App\Http\Controllers\Auth\KakaoLoginController;
use App\Http\Controllers\Auth\NaverLoginController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\CKEditorController;
use \App\Http\Controllers\QnaboardController;

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
Route::post('qnas/{qna}/checkPw/{caller}', [QnaboardController::class, 'checkPw'])->name('qnas.checkPw');
Route::get('qnas/{qna}/createReply',[QnaboardController::class,'createReply'])->name('qnas.create_reply');
Route::post('qnas/{qna}/storeReply',[QnaboardController::class,'storeReply'])->name('qnas.store_reply');

Route::resource('boards', BoardController::class);
Route::resource('qnas', QnaboardController::class);

Route::view('home', 'home')->middleware(['auth', 'verified']);

//Route::view()에서는 이름이 지정되지 않는다. 따로 체인메서드로 name('라우트명')으로 이름을 지정해줘야한다.
Route::view('profile/edit', 'profile.edit')->name('profile.edit')->middleware('auth');

Route::view('profile/password/edit', 'profile.password.edit')->name('profile.password.edit')->middleware('auth');  //컨벤션 질문 passwordEdit

Route::get("worknets", [WorknetController::class, "index"])->name('worknets.index');
Route::get("worknets/{worknet}", [WorknetController::class, "show"])->name('worknets.show');

//이메일중복시 사용자로부터 입력값 받기
Route::view('auth/receive_email', 'auth.receive_email')->name('socialogin.receive');

Route::delete('admin/delete', [AdminController::class, 'delete'])->name('admin.delete');
Route::delete('admin/deleteSelected', [AdminController::class, 'deleteSelected'])->name('admin.deleteSelected');

//auth
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::view('login', 'admin.admin_login')->name('login');
    });
});


//ckeditor
Route::post('ckeditor/upload', [\App\Http\Controllers\CKEditorController::class, 'ImageUpload'])->name('ckeditor.imgUpload');

//social login
Route::get('google/login', [GoogleLoginController::class, 'redirect'])->name('google.login');
Route::get('google/callback', [GoogleLoginController::class, 'callback']);

Route::get('naver/login', [NaverLoginController::class, 'redirect'])->name('naver.login');
Route::post('naver/login', [NaverLoginController::class, 'receiveEmail'])->name('naver.receive');
Route::get('naver/callback', [NaverLoginController::class, 'callback']);

Route::get('kakao/login', [KakaoLoginController::class, 'redirect'])->name('kakao.login');
Route::post('kakao/login', [KakaoLoginController::class, 'receiveEmail'])->name('kakao.receive');
Route::get('kakao/callback', [KakaoLoginController::class, 'callback']);
