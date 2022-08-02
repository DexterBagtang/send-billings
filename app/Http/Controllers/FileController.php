<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function billingFiles(){
        $month = now()->format('F');
        $year = now()->format('Y');

//        dd($month,$year);

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
//        dd($billings);

        $nullFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('clients_id','=',null)
            ->get();
//        dd($nullFiles);
//        if(count($nullFiles) > 0){
//            dd('not null');
//        }
//        else{
//            dd('null');
//        }


        return view('files.billingFiles')->with('billings',$billings)->with('month',$month)->with('year',$year)->with('nullFiles',$nullFiles);
    }

    public function billingFilesPost(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at')
//            ->distinct()
//            ->orderBy('created_at','desc')
            ->get();
//        dd($billings);
        $nullFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('clients_id','=',null)
            ->get();

        return view('files.billingFiles')->with('billings',$billings)->with('month',$month)->with('year',$year)->with('nullFiles',$nullFiles);

    }
}
