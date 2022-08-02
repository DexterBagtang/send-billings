<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        $month = now()->format('F');
        $year = now()->format('Y');

        $billingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
//            ->join('clients','files.clients_id','=','clients.id')
//            ->select('clients.*','files.filename','files.month','files.year','files.emailStatus','files.created_at','files.emailDate')
//            ->distinct()
//            ->orderBy('files.emailDate','desc')
            ->count();
        View::share('finalcountsent',$billingSent);
    }
}
