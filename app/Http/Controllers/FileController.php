<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class FileController extends Controller
{
    public function billingFiles(){
        $month = now()->format('F');
        $year = now()->format('Y');

//        dd($month,$year);

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->get();
//        dd($billings);

        $nullFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('clients_id','=',null)
//            ->groupBy('filename','month','year')
//            ->select('files.filename','files.month','files.year',DB::raw('max(id) as id'))
            ->get();

        $duplicateFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->groupBy('filename')
            ->select('filename',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();

        $deletedFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNotNull('deleted_at')
            ->get();
//        dd($deletedFiles);
//        if(count($nullFiles) > 0){
//            dd('not null');
//        }
//        else{
//            dd('null');
//        }


        return view('files.billingFiles')->with('billings',$billings)->with('month',$month)->with('year',$year)->with('nullFiles',$nullFiles)
            ->with('duplicateFiles',$duplicateFiles)->with('deletedFiles',$deletedFiles);
    }

    public function billingFilesPost(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader')
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

    public function viewDuplicate($filename,$month,$year){
        $duplicateFiles = DB::table('files')
            ->where('filename','=',$filename)
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->get();
//        dd($duplicateFiles);
        return view('files.viewDuplicates')->with('duplicateFiles',$duplicateFiles)->with('month',$month)->with('year',$year);
    }

    public function removeDuplicate($id){
        $duplicate = DB::table('files')
            ->where('id','=',$id)
            ->first();
        return view('files.modal')->with('duplicate',$duplicate);

    }

    public function removeDuplicatePost(Request $request, $id){
        $duplicate = File::find($id);
        $duplicate->deletedBy = Auth::user()->name;
        $duplicate->update();
        $duplicate->delete();


        return back()->with('success','Duplicate removed');
    }

    public function restoreFile($id){
        $restore = File::withTrashed()->find($id);
//        dd($restore);
        $restore->restore();

        return back()->with('success','Billing restored');
    }

}
