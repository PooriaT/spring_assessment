<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Storage;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/leaderboard', [LeaderboardController::class, 'index']);
// Route::get('/leaderboard/qr-code/{filename}', [LeaderboardController::class, 'showQrCode'])->name('qr-code.show');

// Route::get('/leaderboard/qr-code', function () {
//     $filePath = "public/qrImage/nathaniel-dubuque_qr.png";
//     // Check if the file exists
//     if (Storage::exists($filePath)) {
//         // Specify the content type as an image
//         $headers = ['Content-Type' => 'image/png'];

//         // Return the file response
//         return file(storage_path("app/{$filePath}"), $headers);
//     }

//     abort(404);
// });