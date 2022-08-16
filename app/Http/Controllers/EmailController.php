<?php

namespace App\Http\Controllers;

use App\Jobs\ResendJob;
use App\Jobs\SendEmailJob;
use App\Mail\ResendMail;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use function _PHPStan_9a6ded56a\React\Promise\all;

class EmailController extends Controller
{
    public function sendBillingFiles(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->groupBy('files.filename')
            ->select('files.filename',DB::raw('max(files.id) as id'))
            ->get();

        if (count($billingsFilter) < 1){
            return redirect('uploadedFiles')->with('emailError','Please upload invoices first !');
        }

        foreach ($billingsFilter as $filter){
            $billingId = $filter->id;
            $billingIds[]=$billingId;
        }

//        dd($billingsFilter,$billingIds);

        /*$billings = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
//            ->groupBy('files.clients_id')
            ->select('files.*','clients.name','clients.company','clients.email')
//            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
//        dd($billings);*/

        $billingNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->paginate(10);

        $countNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->count();

        /*$billingSending = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
        $countSending = count($billingSending);

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
        $countSent = count($billingSent);

        $billingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
            ->count();*/

//        dd($billingSent);
        return view('emails.billingFiles')
            ->with('billings',$billingNotSent)
            ->with('month',$month)
            ->with('year',$year)
            ->with('notSent',$countNotSent);
//            ->with('countSent',$countSent)
//            ->with('not',$countNotSent);
//            ->with('billingFailed',$billingFailed);

    }

    public function sendBillingFilesPost(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('created_at','desc')
            ->get();
//        dd($billings);

        $billingNotSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
        $countNotSent = count($billingNotSent);

        $billingSending = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
        $countSending = count($billingSending);

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
        $countSent = count($billingSent);

        return view('emails.billingFiles')
            ->with('billings',$billings)
            ->with('month',$month)
            ->with('year',$year)
            ->with('countSending',$countSending)
            ->with('countSent',$countSent)
            ->with('notSent',$countNotSent);
    }
    //---------------SEND BILLINGS NOW------------------------//    //---------------SEND BILLINGS NOW------------------------//    //---------------SEND BILLINGS NOW------------------------//    //---------------SEND BILLINGS NOW------------------------//

    public function sendBillingNow(Request $request){

        $month = $request->input('month');
        $year = $request->input('year');
        $cc=$request->cc;
        $bcc=$request->bcc;
        $subject=$request->subject;

        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->groupBy('files.filename')
            ->select('files.filename',DB::raw('max(files.id) as id'))
            ->get();
        foreach ($billingsFilter as $filter){
            $billingId = $filter->id;
            $billingIds[]=$billingId;
        }

//        $billingsAll = DB::table('files')
//            ->whereIn('files.id',$billingIds)
//            ->where('month','=',$month)
//            ->where('year','=',$year)
//            ->whereNull('deleted_at')
//            ->join('clients','files.clients_id','=','clients.id')
//            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->get();
        $billingsAll = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
            ->count();

//
//        $all=count($billingsAll);
        $all=$billingsAll;
        $each = 4;
        $i=1;
        $delaySecond=1;

        $billingNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
            ->get();
        $countNotSent = count($billingNotSent);

        if ($countNotSent == 0){
//            dd("no billings to be send");
            return redirect('sendBillingFiles')->with('error',"No SOA to be send for the month of $month-$year");
        }
        else{
            for ($x=0; $x<=$all; $x+=$each){
                $billings = DB::table('files')
                    ->whereIn('files.id',$billingIds)
                    ->where('month','=',$month)
                    ->where('year','=',$year)
                    ->where('emailStatus','=','for sending')
                    ->whereNull('deleted_at')
                    ->join('clients','files.clients_id','=','clients.id')
                    ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.id','files.storedFile')
                    ->take($each)
                    ->get();
//            dd($billings);
                $delaySeconds = $i+$delaySecond;

                foreach ($billings as $billing) {
                    $data =[
                      'company' => $billing->company,
                        'month' => $month,
                        'year' => $year,
                    ];

                    $email = $billing->email;
                    $id = $billing->id;
                    $file = public_path("billing_files/$month-$year/$billing->storedFile");

//                    $emailJob = (new SendEmailJob($email,$file,$id,$cc,$bcc,$subject,$data))->delay(now()->addSeconds($delaySeconds));
//                    $emailJob = (new SendEmailJob($email,$file,$id,$cc,$bcc,$subject,$data));

                    $emailJob = (new SendEmailJob($email,$file,$id,$cc,$bcc,$subject,$data));

//                    dispatch($emailJob)->delay(now()->addSeconds($delaySeconds))->onQueue('email');
                    dispatch($emailJob)->delay($delaySeconds)->onQueue('email');


                    $update = File::query()->where('id','=',$id)->first();
                    $update->emailStatus = "sending";
                    $update->emailedBy= Auth::user()->name;
                    $update->update();

                }
                $delaySecond = $i+= 30;
            }
//            dd("email sending");
//            Artisan::queue('queue:listen');

            return back()->with('sending','Statement of Accounts are now sending !');
        }
    }
    //-------------------EMAIL SENT --------------------------//     //-------------------EMAIL SENT --------------------------//    //-------------------EMAIL SENT --------------------------//    //-------------------EMAIL SENT --------------------------//

    public function sendBillingSent(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year',
                'files.emailStatus','files.created_at','files.emailDate','files.emailedBy','files.storedFile')
//            ->distinct()
            ->orderBy('files.emailDate','desc')
            ->get();

//        dd($billingSent);
        $countSent = count($billingSent);
        return view('emails.billingSent')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('countSent',$countSent);
    }

    public function sendBillingSentPost(Request $request){
        $month = $request->month;
        $year = $request->year;

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at','files.emailDate','files.storedFile')
//            ->distinct()
            ->orderBy('files.emailDate','desc')
            ->get();

//        dd($billingSent);
        $countSent = count($billingSent);
        return view('emails.billingSent')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('countSent',$countSent);
    }



    //----------------------EMAIL SENDING -------------------------------------------------------------------------------------------------------------------//

    public function sendBillingSending(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
//            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at')
            ->select('files.*','clients.company','clients.email')

            //            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
        $countSent = count($billingSent);
        return view('emails.billingSending')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('countSent',$countSent);
    }

    //----------------------EMAIL FAILED ---------------------------------------------------------------------------------------------------------------------///

    public function sendBillingFailed(){
//        Artisan::call("queue:retry all");

        $month = now()->format('F');
        $year = now()->format('Y');
        $billingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->get();
        $countFailed = count($billingFailed);

        return view('emails.billingFailed',compact(['countFailed',
            'month','year']))->with('billings',$billingFailed);
    }

    public function resendBilling(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $billingResend = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->get();
        $now = now();
        $delay = now()->addSeconds(30);
        $i=0;
        foreach ($billingResend as $resend){
            $email = $resend->email;
            $file = public_path("billing_files/$resend->month-$resend->year/$resend->storedFile");


            $resendJob = (new ResendJob($email,$file));
            dispatch($resendJob)->onQueue('resend')->delay($i);
            $i = $i + 20;
        }

        dd($billingResend);
    }







}
