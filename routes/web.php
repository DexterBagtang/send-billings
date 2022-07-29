<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;
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
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
//        return view('index');
        return view('index2');
    });
    Route::get('clients',([ClientController::class,'index']));

    Route::get('uploadFile',([UploadController::class,'upload']));
    Route::post('uploadedFile',([UploadController::class,'uploaded']));

    Route::get('uploadedFiles',([UploadController::class,'uploadedFiles']));
    Route::get('viewUploadedFiles/{id}',([UploadController::class,'viewUploadedFiles']));

    //------------------------Billing Files ------------------------------------//
    Route::get('billingFiles',([FileController::class,'billingFiles']));
    Route::post('billingFiles',([FileController::class,'billingFilesPost']));
    //-----------------------Send Billing Files --------------------------------//
    Route::get('sendBillingFiles',([EmailController::class,'sendBillingFiles']));
    Route::post('sendBillingFilesPost',([EmailController::class,'sendBillingFilesPost']));
    Route::post('sendBillingNow',([EmailController::class,'sendBillingNow']));
    Route::get('sendBillingSent',([EmailController::class,'sendBillingSent']));
    Route::get('sendBillingSending',([EmailController::class,'sendBillingSending']));


});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
