<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\UploadController;
use App\Http\Middleware\CheckAdmin;
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
//        $billingSent = DB::table('files')
//            ->where('month','=',$month)
//            ->where('year','=',$year)
//            ->where('emailStatus','=','sent')
//            ->join('clients','files.clients_id','=','clients.id')
//            ->select('clients.*','files.filename','files.month','files.year',
//                'files.emailStatus','files.created_at','files.emailDate','files.emailedBy','files.storedFile')
////            ->distinct()
//            ->orderBy('files.emailDate','desc')
//            ->paginate(20);

        $sent = DB::table('files')->groupBy('month')->select('month',DB::raw("COUNT(*) as count"))->get();

        $labels = $sent->keys();
        $data = $sent->values();
        dd($labels,$data);
//        dd($sent);
//        return view('index');
        return view('index',compact('labels','data'));
    });
    //-----------------Dashboard-----------------------------------//
    Route::get('/',([DashboardController::class,'dashboard']));

    //-----------------Clients-------------------------------------//
    Route::get('clients/',([ClientController::class,'index']));
    Route::get('addClient',([ClientController::class,'addClient']));
    Route::post('addedClient',([ClientController::class,'addedClient']));
    Route::get('editClient/{id}',([ClientController::class,'editClient']));
    Route::post('editedClient',([ClientController::class,'editedClient']));
    Route::get('viewClient/{id}',([ClientController::class,'viewClient']));
    Route::get('removeClient/{id}',([ClientController::class,'removeClient']));
    Route::post('removedClient',([ClientController::class,'removedClient']));
    Route::get('removeClientDuplicate/{id}',([ClientController::class,'removeClientDuplicate']));
    Route::post('removedClientDuplicate',([ClientController::class,'removedClientDuplicate']));
    Route::get('edit_client/{id}',([ClientController::class,'edit_client']));
    Route::post('importClient',([ClientController::class,'importClient']));
    Route::get('duplicateClient',([ClientController::class,'duplicateClient']));
    Route::get('searchClient',([ClientController::class,'searchClient']));
    Route::get('searchDuplicateClient',([ClientController::class,'searchDuplicateClient']));



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
    Route::get('billingSearch',([FileController::class,'billingSearch']));
    //---------------------billing Unknown --------------------------------------
    Route::get('billingUnknown',([FileController::class,'billingUnknown']));
    Route::get('unknownSearch',([FileController::class,'unknownSearch']));
    //---------------------billing Duplicate --------------------------------
    Route::get('billingDuplicate',([FileController::class,'billingDuplicate']));
    Route::get('viewDuplicate/{filename}/{month}/{year}',([FileController::class,'viewDuplicate']));
    Route::get('duplicateSearch',([FileController::class,'duplicateSearch']));
    Route::get('removeDuplicate/{id}',([FileController::class,'removeDuplicate']));
    Route::post('removeDuplicatePost/{id}',([FileController::class,'removeDuplicatePost']));
    //-------------------------billing removed  ----------------------------------
    Route::get('billingRemoved',([FileController::class,'billingRemoved']));
    Route::get('restoreFile/{id}',([FileController::class,'restoreFile']));
    Route::get('removedSearch',([FileController::class,'removedSearch']));

    //-----------------------Send Billing Files --------------------------------//
    Route::get('sendBillingFiles',([EmailController::class,'sendBillingFiles']));
    Route::post('sendBillingFilesPost',([EmailController::class,'sendBillingFilesPost']));
    Route::post('sendBillingNow',([EmailController::class,'sendBillingNow']));
    Route::get('sendBillingSent',([EmailController::class,'sendBillingSent']));
    Route::get('sendBillingSentPost',([EmailController::class,'sendBillingSentPost']));
    Route::get('sendBillingSending',([EmailController::class,'sendBillingSending']));
    Route::get('sendBillingFailed',([EmailController::class,'sendBillingFailed']));

    Route::get('resendBilling/{id}',([EmailController::class,'resendBilling']));

    Route::get('resendBillingFiles',([EmailController::class,'resendBillingFiles']));
    Route::post('resendBillingNow',([EmailController::class,'resendBillingNow']));


    //---------------------Search SoA ---------------------------------------------//
    Route::get('searchSend',([EmailController::class,'searchSend']));
    Route::get('searchSent',([EmailController::class,'searchSent']));
    Route::get('searchSending',([EmailController::class,'searchSending']));
    Route::get('searchFailed',([EmailController::class,'searchFailed']));
    Route::get('searchResend',([EmailController::class,'searchResend']));


    //------------------Account Profile ---------------------------------------------//
    Route::get('account',([DashboardController::class,'account']));
    Route::post('uploadProfile',([DashboardController::class,'uploadProfile']));


    //------------------Admin-------------------------------------------------------//
    Route::middleware('checkAdmin')->group(function () {
        Route::get('users',([AdminController::class,'users']));
        Route::post('search-users',([AdminController::class,'searchUsers']));
    });

    //----------------Recipient-----------------------------------------------//

    Route::get('recipients',([RecipientController::class,'recipients']));
    Route::get('searchRecipient',([RecipientController::class,'searchRecipient']));
    Route::get('addRecipient',([RecipientController::class,'addRecipient']));
    Route::post('storeRecipient',([RecipientController::class,'storeRecipient']));
    Route::get('editRecipient/{id}',([RecipientController::class,'editRecipient']));
    Route::post('updateRecipient',([RecipientController::class,'updateRecipient']));
    Route::get('removeRecipient/{id}',([RecipientController::class,'removeRecipient']));
    //===========================    Announcement  =================================================//
    Route::get('announcements',([AnnouncementController::class,'announcements']));
    Route::post('sendAnnouncement',([AnnouncementController::class,'sendAnnouncement']));

    //test delete using bootbox
    Route::any('delete',([RecipientController::class,'destroy']));


});





require __DIR__.'/auth.php';


