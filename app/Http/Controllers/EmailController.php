<?php

namespace App\Http\Controllers;

use App\Jobs\ResendJob;
use App\Jobs\SendEmailJob;
use App\Mail\ResendMail;
use App\Models\File;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use function _PHPStan_9a6ded56a\React\Promise\all;

class EmailController extends Controller
{
    public function sendBillingFiles(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;

        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
//            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->groupBy('files.filename')
            ->select('files.filename',DB::raw('max(files.id) as id'))
            ->get();
//        dd($billingsFilter);

        if (count($billingsFilter) < 1){
            return redirect('uploadedFiles')->with('emailError','Please upload invoices first !');
        }

        foreach ($billingsFilter as $filter){
            $billingId = $filter->id;
            $billingIds[]=$billingId;
        }


        $billingNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->where('files.deleted_at','=',null)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email','clients.incharge_email')
            ->paginate(10);
//        dd($billingNotSent);

        $countNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
            ->count();

        $billingSending = DB::table('files')
//            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('emailStatus','=','sending')
            ->count();


        return view('emails.billingFiles')
            ->with('billings',$billingNotSent)
            ->with('month',$month)
            ->with('year',$year)
            ->with('billingSending',$billingSending)
            ->with('notSent',$countNotSent)
//            ->with('incharge',$incharge)
            ->with('search',$search);
    }

    /*public function sendBillingFilesPost(Request $request){
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
    }*/

    public function searchSend(Request $request){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = $request->search;

        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
//            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->groupBy('files.filename')
            ->select('files.filename',DB::raw('max(files.id) as id'))
            ->get();
//        dd($billingsFilter);

        if (count($billingsFilter) < 1){
            return redirect('uploadedFiles')->with('emailError','Please upload invoices first !');
        }

        foreach ($billingsFilter as $filter){
            $billingId = $filter->id;
            $billingIds[]=$billingId;
        }
        $billingNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->where('files.deleted_at','=',null)
            ->where(function ($query) use ($search){
                $query->where('clients.company','like',"%$search%")
                    ->orWhere('files.filename','like',"%$search%")
                    ->orWhere('clients.email','like',"%$search%");
            })
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
            ->paginate(10);

        $countNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for sending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
            ->count();
        $billingSending = DB::table('files')
//            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('emailStatus','=','sending')
            ->count();
        return view('emails.billingFiles')
            ->with('billings',$billingNotSent)
            ->with('month',$month)
            ->with('year',$year)
            ->with('billingSending',$billingSending)
            ->with('notSent',$countNotSent)
            ->with('search',$search);
    }
    //---------------SEND BILLINGS NOW------------------------//    //---------------SEND BILLINGS NOW------------------------//    //---------------SEND BILLINGS NOW------------------------//    //---------------SEND BILLINGS NOW------------------------//

    public function sendBillingNow(Request $request){

//        dd($request->message);
        $month = $request->input('month');
        $year = $request->input('year');
        $cc=$request->cc;
        $bcc=$request->bcc;
        $subjectInput=$request->subject;
        $contents=$request->message;

        if ($request->hasFile('attachment')){
            foreach ($request->file('attachment')as $file){
                //            $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $file->move(public_path("attachments"), $name);
                $names[]=$name;
            }
        }else{
            $names[] = null;
        }
//        dd($names);
        $attachment = $names;
//============ Filters the files , selects the latest files in case of duplicate files ============//
        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
//            ->where('emailStatus','=','for sending')
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
        $each = 5;
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
                    $content = str_replace('|incharge|',"$billing->incharge_email",$contents);
                    $data =[
                      'company' => $billing->company,
                        'month' => $month,
                        'year' => $year,
                        'content' => $content,
                        'incharge' => $billing->incharge_email,
                    ];


                    $email = $billing->email;
                    $id = $billing->id;
//                    $subject = "Account No - $billing->account_number Contract No - $billing->contract_number $billing->company ".$subjectInput;
                    $subject = "$billing->account_number$billing->contract_number $billing->company ".$subjectInput;

                    $file = public_path("billing_files/$month-$year/$billing->storedFile");
//                    $attachment = public_path("attachments/$name");
//                    $attachment = $names;

                    $emailJob = (new SendEmailJob($email,$file,$id,$cc,$bcc,$subject,$data,$attachment));
                    dispatch($emailJob)->delay($delaySeconds)->onQueue('email');


                    $update = File::query()->where('id','=',$id)->first();
                    $update->emailStatus = "sending";
                    $update->emailedBy= Auth::user()->name;
                    $update->subject=$subject;
                    $update->contents = $content;
                    $update->attachment = json_encode($attachment);
                    $update->update();

                    $logs = new SystemLog([
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'user' => Auth::user()->name,
                        'action' => $update,
                        'module' => 'for send',
                    ]);
                    $logs->save();

                }
                $delaySecond = $i+= 45;
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
        $search = null;

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->orderBy('files.emailDate','desc')
            ->paginate(20);

//        dd($billingSent);
        $countSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.id')
            ->orderBy('files.emailDate','desc')
            ->count();
        return view('emails.billingSent')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('search',$search)
            ->with('countSent',$countSent);
    }

    public function viewBilling($id){
        $billingSent = DB::table('files')
            ->where('files.id','=',$id)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->orderBy('files.emailDate','desc')
            ->first();
//        dd($billingSent);
        return view('emails.viewBilling')->with('billing',$billingSent);
    }

    public function sendBillingSentPost(Request $request){
        $month = $request->month;
        $year = $request->year;
        $search = null;

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->orderBy('files.emailDate','desc')
            ->paginate(50);

        $countSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.id')
            ->orderBy('files.emailDate','desc')
            ->count();


        return view('emails.billingSent')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('search',$search)
            ->with('countSent',$countSent);
    }

    public function searchSent(Request $request){
        $month = $request->month;
        $year = $request->year;
        $search = $request->search;

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->where(function ($query) use ($search){
                $query->where('clients.company','like',"%$search%")
                    ->orWhere('files.filename','like',"%$search%")
                    ->orWhere('files.emailedBy','like',"%$search%")
//                    ->orWhere('files.filename','like',"%$search%")
                    ->orWhere('clients.email','like',"%$search%");
            })
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->orderBy('files.emailDate','desc')
            ->paginate(50);

        $countSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.id')
            ->orderBy('files.emailDate','desc')
            ->count();


        return view('emails.billingSent')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('search',$search)
            ->with('countSent',$countSent);
    }



    //----------------------EMAIL SENDING -------------------------------------------------------------------------------------------------------------------//

    public function sendBillingSending(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->paginate(50);
//        dd($billingSent);

        $countSending = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->count();
//
        return view('emails.billingSending')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('search',$search)
            ->with('countSent',$countSending);
    }

    public function searchSending(Request $request){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = $request->search;

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->where(function ($query) use ($search){
                $query->where('clients.company','like',"%$search%")
                    ->orWhere('files.filename','like',"%$search%")
                    ->orWhere('clients.email','like',"%$search%");
            })
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->paginate(50);

        $countSending = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->count();
//
        return view('emails.billingSending')
            ->with('month',$month)
            ->with('year',$year)
            ->with('billings',$billingSent)
            ->with('search',$search)
            ->with('countSent',$countSending);
    }

    //----------------------EMAIL FAILED ---------------------------------------------------------------------------------------------------------------------///

    public function sendBillingFailed(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;
        $billingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->orWhere('emailStatus','=','resending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->paginate(20);
//        dd($billingFailed);

        $countFailed =  DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->count();
//        dd($billingFailed);
        $url = request()->fullUrl();
        Session::put('data_url',$url);


        return view('emails.billingFailed',compact([
            'countFailed',
            'month',
            'year']))
            ->with('billings',$billingFailed)
            ->with('search',$search);
    }

    public function searchFailed(Request $request){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = $request->search;

        $billingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->where(function ($query) use ($search){
                $query->where('clients.company','like',"%$search%")
                    ->orWhere('files.filename','like',"%$search%")
                    ->orWhere('clients.email','like',"%$search%");
            })
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->paginate(20);

        $countFailed =  DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->count();


        return view('emails.billingFailed',compact(['countFailed',
            'month','year']))
            ->with('billings',$billingFailed)
            ->with('search',$search);
    }


    public function resendBilling($id){

        $update = File::query()->where('id','=',$id)->first();
        $update->emailStatus = "for resending";
        $update->emailedBy= Auth::user()->name;
        $update->update();

        if (Session('data_url')){
            return redirect(Session('data_url'))->with('resend','successful resend');
        }
        return back()->with('sending','sending in process !');
    }


    public function resendBillingFiles(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;

        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
//            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->groupBy('files.filename')
            ->select('files.filename',DB::raw('max(files.id) as id'))
            ->get();
//        dd($billingsFilter);

        if (count($billingsFilter) < 1){
            return redirect('uploadedFiles')->with('emailError','Please upload invoices first !');
        }

        foreach ($billingsFilter as $filter){
            $billingId = $filter->id;
            $billingIds[]=$billingId;
        }

        $billingNotSent = DB::table('files')
//            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','like','%for resending%')
            ->where('files.deleted_at','=',null)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->paginate(10);
//        dd($billingNotSent);

        $countNotSent = DB::table('files')
//            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for resending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->count();
        $billingSending = DB::table('files')
//            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('emailStatus','=','sending')
            ->count();

        return view('emails.resendBillingFiles')
            ->with('billings',$billingNotSent)
            ->with('month',$month)
            ->with('year',$year)
            ->with('billingSending',$billingSending)
            ->with('notSent',$countNotSent)
            ->with('search',$search);
    }


    public function resendBillingNow(Request $request){

//        dd($request->message);
        $month = $request->input('month');
        $year = $request->input('year');
        $cc=$request->cc;
        $bcc=$request->bcc;
        $subjectInput=$request->subject;
        $contents=$request->message;

        if ($request->hasFile('attachment')){
            foreach ($request->file('attachment')as $file){
                //            $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $file->move(public_path("attachments"), $name);
                $names[]=$name;
            }
        }else{
            $names[] = null;
        }
//        dd($names);
        $attachment = $names;
//============ Filters the files , selects the latest files in case of duplicate files ============//
        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
//            ->where('emailStatus','=','for sending')
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
        $each = 5;
        $i=1;
        $delaySecond=1;

        $billingNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for resending')
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
                    ->where('emailStatus','=','for resending')
                    ->whereNull('deleted_at')
                    ->join('clients','files.clients_id','=','clients.id')
                    ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.id','files.storedFile')
                    ->take($each)
                    ->get();
//            dd($billings);
                $delaySeconds = $i+$delaySecond;

                foreach ($billings as $billing) {
                    $content = str_replace('|incharge|',"$billing->incharge_email",$contents);
                    $data =[
                        'company' => $billing->company,
                        'month' => $month,
                        'year' => $year,
                        'content' => $content,
                        'incharge' => $billing->incharge_email,
                    ];


                    $email = $billing->email;
                    $id = $billing->id;
//                    $subject = "Account No - $billing->account_number Contract No - $billing->contract_number $billing->company  ".$subjectInput;
                    $subject = "$billing->account_number$billing->contract_number $billing->company ".$subjectInput;
                    $file = public_path("billing_files/$month-$year/$billing->storedFile");
//                    $attachment = public_path("attachments/$name");
//                    $attachment = $names;

                    $emailJob = (new SendEmailJob($email,$file,$id,$cc,$bcc,$subject,$data,$attachment));
                    dispatch($emailJob)->delay($delaySeconds)->onQueue('email');


                    $update = File::query()->where('id','=',$id)->first();
                    $update->emailStatus = "sending";
                    $update->emailedBy= Auth::user()->name;
                    $update->subject=$subject;
                    $update->update();

                }
                $delaySecond = $i+= 45;
            }
//            dd("email sending");
//            Artisan::queue('queue:listen');

            return back()->with('sending','Statement of Accounts are now resending !');
        }
    }


    public function searchResend(Request $request){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = $request->search;

        $billingsFilter = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
//            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->groupBy('files.filename')
            ->select('files.filename',DB::raw('max(files.id) as id'))
            ->get();
//        dd($billingsFilter);

        if (count($billingsFilter) < 1){
            return redirect('uploadedFiles')->with('emailError','Please upload invoices first !');
        }

        foreach ($billingsFilter as $filter){
            $billingId = $filter->id;
            $billingIds[]=$billingId;
        }
        $billingNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for resending')
            ->where('files.deleted_at','=',null)
            ->where(function ($query) use ($search){
                $query->where('clients.company','like',"%$search%")
                    ->orWhere('files.filename','like',"%$search%")
                    ->orWhere('clients.email','like',"%$search%");
            })
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
            ->paginate(10);

        $countNotSent = DB::table('files')
            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','for resending')
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.name','clients.company','clients.email')
            ->count();
        $billingSending = DB::table('files')
//            ->whereIn('files.id',$billingIds)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('emailStatus','=','sending')
            ->count();
        return view('emails.billingFiles')
            ->with('billings',$billingNotSent)
            ->with('month',$month)
            ->with('year',$year)
            ->with('billingSending',$billingSending)
            ->with('notSent',$countNotSent)
            ->with('search',$search);
    }

    public function getId($empid){
        $billing = DB::table('files')
            ->where('files.id','=',$empid)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->first();
//        dd($billing);
        $view = view('emails.viewBilling2')->with('billing',$billing)->render();
//        $view = View::make('emails.viewBilling', (array)$billing);
//        dd($view);

        $html = "";
        if (!empty($billing)){
            $html = $view;
        }

        $response['html'] = $html;

        return response()->json($response);

    }







}
