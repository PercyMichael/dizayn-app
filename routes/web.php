<?php

use App\Http\Controllers\RegisterUser;
use App\Http\Controllers\SessionController;
use App\Models\Checkin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    $checkins = Checkin::all();

    // Group check-ins by month
    $checkinsByMonth = $checkins->groupBy(function ($checkin) {
        return Carbon::parse($checkin->created_at)->format('Y-m');
    });

    dump($checkinsByMonth);

    $user = Auth::user();

    $today = date('Y-m-d'); // Get today's date at the beginning of the day

    $checkedInToday = Checkin::where('user_id', $user->id)
        ->whereDate('created_at', $today)
        ->exists();

    return view('welcome', compact('checkinsByMonth', 'checkedInToday'));
})->middleware(['auth', 'verified']);


Route::post('/checkin', function () {

    $user = Auth::user();

    Checkin::create([
        'user_id' => $user->id
    ]);

    return redirect('/')->with('successfull_checkin', 'You have checked in successfully');
})->middleware(['auth', 'verified']);


//signout
Route::get('/signup', [RegisterUser::class, 'create']);
Route::post('/signup', [RegisterUser::class, 'store']);

//signin
Route::get('/signin', [SessionController::class, 'create'])->name('login');
Route::post('/signin', [SessionController::class, 'store']);

//signout
Route::post('/signout', [SessionController::class, 'destroy']);

Route::get('/email/verify', [RegisterUser::class, 'showEmailVerification'])->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [RegisterUser::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', [RegisterUser::class, 'verifyNotification'])->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
//finish auth
