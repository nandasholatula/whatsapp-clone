<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\UserCred;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('contact', [MessageController::class, 'contact']);
Route::post('test', [HomeController::class, 'testing'])->name('test');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fire', function () {
    $data = array('msg' => 'hello world asdsadsasda');
    event(new \App\Events\TestEvent($data));
    return 'ok';
});
Auth::routes();

Route::group(['middleware' => ['role:admin']], function () {

    Route::group(['prefix' => 'manage'], function () {
        Route::get('/user', function () {
            return view('userApproval');
        })->name('approval');
        Route::get('/cred', function () {
            return view('credential');
        })->name('credential');
    });

    Route::group(['prefix' => 'creds'], function () {
        Route::get('/', [CredentialController::class, 'index']);
        Route::post('/', [CredentialController::class, 'store']);
        Route::put('/{credential}', [CredentialController::class, 'update'])->name('credential.update');
    });

    Route::group(['prefix' => 'assign'], function () {
        Route::get('/', [AdminController::class, 'userApproval']);
        Route::post('/', [AdminController::class, 'assignUser']);
        Route::get('/active/{id}', [AdminController::class, 'activeUser']);
    });
});

Route::group(['middleware' => 'auth'], function () {

    Route::post('/reqAssign', [AdminController::class, 'requestCred'])->name('assign.cred');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::group(['prefix' => 'chat-api'], function () {

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'me']);
            Route::get('/status', [UserController::class, 'status']);
            Route::get('/qrcode', [UserController::class, 'qrCode']);
        });

        Route::group(['prefix' => 'message'], function () {
            Route::get('/', [MessageController::class, 'messages']);
            Route::get('/latest', [MessageController::class, 'latest']);
            Route::post('/text', [MessageController::class, 'sendText']);
            Route::post('/file', [MessageController::class, 'sendFile']);
            Route::get('/delete', [MessageController::class, 'delete']);
        });

        Route::group(['prefix' => 'dialog'], function () {
            Route::get('/', [DialogController::class, 'dialogs']);
            Route::get('/{chatId}', [DialogController::class, 'dialog']);
        });
    });

    Route::group(['prefix' => 'db'], function () {
        Route::post('/message', [MessageController::class, 'store']);
    });

    Route::group(['prefix' => 'credential'], function () {
        Route::get('/getcred', function () {
            return UserCred::with('user', 'credential')->where('user_id', auth()->id())->first();
        });
        Route::get('/{credential}', [CredentialController::class, 'show']);
    });

    Route::group(['prefix' => 'chat'], function () {

        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', [DialogController::class, 'contact']);
            Route::get('/{chatid}', [DialogController::class, 'selected']);
            Route::get('/cred/{id}', [DialogController::class, 'contactWithCred']);
            Route::get('/page/{page}', [DialogController::class, 'contactPerPage']);
            Route::get('/page/{page}/cred/{cred}', [DialogController::class, 'contactPerPageWithCred']);
            Route::get('/search/{name}', [DialogController::class, 'searchContact']);
        });

        Route::post('/upload', [ImageController::class, 'upload']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/me', [UserController::class, 'getMe']);
        Route::get('/role', [UserController::class, 'getRole']);
    });
});
