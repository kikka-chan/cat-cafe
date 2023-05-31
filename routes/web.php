<?php

use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them willsa
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//お問い合わせフォーム
Route::get('/contact', [ContactController::class,'index'])->name('contact');
Route::post('/contact',[ContactController::class,'sendMail']);
Route::get('/contact/complete', [ContactController::class,'complete'])->name('contact.complete');

//管理画面
Route::prefix('/admin')
    ->name('admin.')
    ->group(function (){
        //ログイン時のみアクセス可能なルート
        Route::middleware('auth')
            ->group(function (){
                //ブログ
                Route::resource('/blogs', AdminBlogController::class)->except('show');

                Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            });




    //未ログイン時のみアクセス可能なルート
    Route::middleware('guest')
        ->group(function (){
            //認証
            Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AuthController::class, 'login']);
        });
    });
