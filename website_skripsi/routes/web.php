<?php

use App\Http\Controllers\ImageController;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Requests\DecryptRequest;
use App\Http\Requests\EncryptRequest;
use App\Rules\Prime;
use Illuminate\Http\JsonResponse;
use App\Services\ValidateInput;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('login', [
            'title'=>'Login',
            'active'=>'register'
        ]);
    });    

    Route::get('/login', function () {
        return view('login', [
            'title'=>'Login',
            'active'=>'register'
        ]);
    })->name('login');    

    Route::get('/register', function () {
        return view('register', [
            'title'=>'Register',
            'active'=>'register'
        ]);
    });    
    
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    });
    
    Route::get('/decrypt', function () {
        return view('decrypt');
    });
    
    Route::get('/encrypt', function () {
        $users = User::all();
        return view('encrypt', [
            'users' => $users,
        ]);
    });

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::post('/decrypt', [ImageController::class, 'decrypt']);
    Route::post('/encrypt', [ImageController::class, 'encrypt']);
    
    Route::post('/send-image', [ImageController::class, 'sendImage']);
    Route::get('/get-image/{user}', [ImageController::class, 'getImage']);
    Route::GET('/image/{image}', [ImageController::class, 'show']);
});
