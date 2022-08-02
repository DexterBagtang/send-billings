<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function sendBillingFiles(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
//            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();

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

        $billingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
            ->count();

//        dd($billingSent);
        return view('emails.billingFiles')
            ->with('billings',$billings)
            ->with('month',$month)
            ->with('year',$year)
            ->with('countSending',$countSending)
            ->with('countSent',$countSent)
            ->with('notSent',$countNotSent)
            ->with('billingFailed',$billingFailed);

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

    public function sendBillingNow(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
//        dd($month,$year);



        $billingsAll = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus')
//            ->distinct()
//            ->orderBy('created_at','desc')
            ->get();

        $all=count($billingsAll);
        $each = 4;
        $i=1;
        $delaySecond=1;

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

        if ($countNotSent == 0){
//            dd("no billings to be send");
            return redirect('sendBillingFiles')->with('error',"No billings to be send for the month of $month-$year");
        }
        else{
            for ($x=0; $x<=$all; $x+=$each){
                $billings = DB::table('files')
                    ->where('month','=',$month)
                    ->where('year','=',$year)
                    ->where('emailStatus','=','for sending')
                    ->join('clients','files.clients_id','=','clients.id')
                    ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.id')
                    ->take($each)
//            ->distinct()
//            ->orderBy('created_at','desc')
                    ->get();
//            dd($billings);

                $delaySeconds = $i+$delaySecond;

                foreach ($billings as $billing) {

                    $email = $billing->email;
                    $id = $billing->id;
                    $file = public_path("billing_files/$month-$year/$billing->filename");

//                $update = File::find($billing->id);


//                dd($update);

                    $emailJob = (new SendEmailJob($email,$file,$id))->delay(now()->addSeconds($delaySeconds));
                    dispatch($emailJob);

                    $update = File::query()->where('id','=',$id)->first();
                    $update->emailStatus = "sending";
                    $update->update();

                }
                $delaySecond = $i+= 30;
            }
//            dd("email sending");
            return back()->with('sending','Billings are now sending !');
        }
    }

    public function sendBillingSent(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at','files.emailDate')
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

    public function sendBillingSending(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at')
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

    public function sendBillingFailed(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $billingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at')
            ->get();
        $countFailed = count($billingFailed);

        return view('emails.billingFailed',compact(['countFailed',
            'month','year']))->with('billings',$billingFailed);
    }
}
