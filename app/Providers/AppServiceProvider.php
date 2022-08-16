<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
//
//        $month = now()->format('F');
//        $year = now()->format('Y');
//
//        $billingSent = DB::table('files')
//            ->where('month','=',$month)
//            ->where('year','=',$year)
//            ->where('emailStatus','=','sent')
////            ->join('clients','files.clients_id','=','clients.id')
////            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at','files.emailDate')
////            ->distinct()
////            ->orderBy('files.emailDate','desc')
//            ->count();
//        View::share('finalcountsent',$billingSent);

        $month = now()->format('F');
        $year = now()->format('Y');

        $billingSending = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('emailStatus','=','sending')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('files.*','clients.company','clients.email')
            ->get();
        View::share('sendings',$billingSending);

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->count();
        View::share('soaCount',$billings);

        $nullFiles = DB::table('files')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->whereNull('deleted_at')
            ->where('clients_id', '=', null)
            ->count();
        View::share('unknownCount',$nullFiles);

        $duplicateFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->groupBy('filename')
            ->select('filename',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->count();
        View::share('duplicateCount',$duplicateFiles);

        $deletedFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNotNull('deleted_at')
            ->count();
        View::share('removedCount',$deletedFiles);


    }
}
