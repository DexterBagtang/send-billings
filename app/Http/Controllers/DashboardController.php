<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(){
        $month = now()->format('F');
        $year = now()->format('Y');

        $clientsCount = DB::table('clients')->count();
        $billingsCount = DB::table('files')->count();

        $monthBillings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
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
        return view('index2')
            ->with('month',$month)
            ->with('year',$year)
            ->with('monthBillings',$monthBillings)
            ->with('sent',$monthBillingSent)
            ->with('sending',$monthBillingSending)
            ->with('failed',$monthBillingFailed)
            ->with('clientsCount',$clientsCount)
            ->with('billingsCount',$billingsCount);

    }

}
