<?php

namespace App\Http\Controllers;

use _PHPStan_9a6ded56a\Nette\Neon\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function dashboard(){

        $month = now()->format('F');
        $year = now()->format('Y');

        $clientsCount = DB::table('clients')->count();
        $billingsCount = DB::table('files')
            ->whereNull('deleted_at')
            ->count();

        $monthBillings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->count();

        $monthBillingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->count();

        $monthBillingSending = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->count();

        $monthBillingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->count();

        $time = date('H');
        if ($time < 12){
            $greet = "Good morning";
        }elseif($time >= 12 && $time < 17){
            $greet = "Good afternoon";
        }elseif($time >= 17 && $time < 19){
            $greet = "Good evening";
        }else{
            $greet = "Good night";
        }

//        dd($greet);

        return view('index2')
            ->with('month',$month)
            ->with('year',$year)
            ->with('monthBillings',$monthBillings)
            ->with('sent',$monthBillingSent)
            ->with('sending',$monthBillingSending)
            ->with('failed',$monthBillingFailed)
            ->with('clientsCount',$clientsCount)
            ->with('billingsCount',$billingsCount)
            ->with('greet',$greet);

    }

}
