<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
    Route::get('test', function () {
//
//        return view('index');
        return view('index');
    });
    //-----------------Dashboard-----------------------------------//
    Route::get('/',([DashboardController::class,'dashboard']));

    //-----------------Clients-------------------------------------//
    Route::get('clients',([ClientController::class,'index']));
    Route::get('addClient',([ClientController::class,'addClient']));
    Route::post('addedClient',([ClientController::class,'addedClient']));
    Route::get('editClient/{id}',([ClientController::class,'editClient']));
    Route::post('editedClient',([ClientController::class,'editedClient']));
    Route::get('edit_client/{id}',([ClientController::class,'edit_client']));
    Route::post('importClient',([ClientController::class,'importClient']));


    //------------------------UPload--------------------------------------//

    Route::get('uploadFile',([UploadController::class,'upload']));
    Route::post('uploadedFile',([UploadController::class,'uploaded']));

    Route::get('uploadedFiles',([UploadController::class,'uploadedFiles']));
    Route::get('viewUploadedFiles/{id}',([UploadController::class,'viewUploadedFiles']));

    Route::get('uploadDemoFiles',([UploadController::class,'uploadDemoFiles']));
    Route::post('uploadDemoFilesPost',([UploadController::class,'uploadDemoFilesPost']));

    Route::get('generateClientsPdf',([UploadController::class,'generatePDF']));



    //------------------------Billing Files ------------------------------------//
    Route::get('billingFiles',([FileController::class,'billingFiles']));
    Route::post('billingFiles',([FileController::class,'billingFilesPost']));
    Route::get('viewDuplicate/{filename}/{month}/{year}',([FileController::class,'viewDuplicate']));
    Route::get('removeDuplicate/{id}',([FileController::class,'removeDuplicate']));
    Route::post('removeDuplicatePost/{id}',([FileController::class,'removeDuplicatePost']));
    Route::get('restoreFile/{id}',([FileController::class,'restoreFile']));
    //-----------------------Send Billing Files --------------------------------//
    Route::get('sendBillingFiles',([EmailController::class,'sendBillingFiles']));
    Route::post('sendBillingFilesPost',([EmailController::class,'sendBillingFilesPost']));
    Route::post('sendBillingNow',([EmailController::class,'sendBillingNow']));
    Route::get('sendBillingSent',([EmailController::class,'sendBillingSent']));
    Route::post('sendBillingSentPost',([EmailController::class,'sendBillingSentPost']));
    Route::get('sendBillingSending',([EmailController::class,'sendBillingSending']));
    Route::get('sendBillingFailed',([EmailController::class,'sendBillingFailed']));


});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


