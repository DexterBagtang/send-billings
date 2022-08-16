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
        $search = null;

//        dd($month,$year);

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile')
//            ->distinct()
//            ->orderBy('files.created_at','desc')
            ->paginate(10);
        return view('files.billingFiles')->with('billings',$billings)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function billingSearch(Request $request){
        $month = $request->input('month');
        $year= $request->input('year');
        $search = $request->input('search');
//        dd($month,$year,$search);

/*        $billingss = DB::table('files')
            ->where('clients.company','like',"%$search%")
            ->orWhere('clients.account_number','like',"%$search%")
            ->orWhere('clients.contract_number','like',"%$search%")
            ->orWhere('clients.email','like',"%$search%")
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile','files.id')
            ->get();
        if (count($billingss) > 0){
            foreach($billingss as $id){
                $ids[] = $id->id;
            }
            $billings = DB::table('files')
                ->whereIn('files.id',$ids)
                ->where('month','=',$month)
                ->where('year','=',$year)
                ->whereNull('deleted_at')
                ->join('clients','files.clients_id','=','clients.id')
                ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile','files.id')
                ->paginate(10);
        }else{
            $billings=DB::table('files')->where('id',null)->paginate();
        }*/

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where(function ($query) use ($search){
                $query->where('clients.company','like',"%$search%")
                    ->orWhere('clients.account_number','like',"%$search%")
                    ->orWhere('clients.contract_number','like',"%$search%")
                    ->orWhere('clients.email','like',"%$search%");
            })
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile','files.id')
            ->paginate(10);


/*        $billings = DB::table('files')
            ->where('clients.company','like',"%$search%")
            ->orWhere('clients.account_number','like',"%$search%")
            ->orWhere('clients.contract_number','like',"%$search%")
//            ->orWhere('clients.email','like',"%$search%")
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile','files.id')
            ->paginate(10);



        dd($billingss,$ids,$billings);


        dd($billingss);*/
        return view('files.billingFiles')->with('billings',$billings)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function billingUnknown(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;
        $nullFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('clients_id','=',null)
            ->paginate(10);
        return view('files.billingUnknown')->with('nullFiles',$nullFiles)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function unknownSearch(Request $request){
        $month = $request->input('month');
        $year= $request->input('year');
        $search = $request->input('search');
        $nullFiles = DB::table('files')
            ->where('filename','like',"%$search%")
            ->orWhere('uploader','like',"%$search%")
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->where('clients_id','=',null)
            ->paginate(10);
//        dd($nullFiles);
        return view('files.billingUnknown')->with('nullFiles',$nullFiles)->with('month',$month)->with('year',$year)->with('search',$search);
    }


    public function billingDuplicate(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;
        $duplicateFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->groupBy('filename')
            ->select('filename',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->paginate(10);
        return view('files.billingDuplicate')->with('duplicateFiles',$duplicateFiles)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function duplicateSearch(Request $request ){
        $month = $request->input('month');
        $year= $request->input('year');
        $search = $request->input('search');
        $duplicateFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('filename','like',"%$search%")
            ->orWhere('uploader','like',"%$search%")
            ->whereNull('deleted_at')
            ->groupBy('filename')
            ->select('filename',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->paginate(10);
        return view('files.billingDuplicate')->with('duplicateFiles',$duplicateFiles)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function billingRemoved(){
        $month = now()->format('F');
        $year = now()->format('Y');
        $search = null;
        $deletedFiles = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNotNull('deleted_at')
            ->paginate(10);
        return view('files.billingRemoved')->with('deletedFiles',$deletedFiles)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function removedSearch(Request $request){
        $month = $request->input('month');
        $year= $request->input('year');
        $search = $request->input('search');

        /*$deletedFiles = DB::table('files')
            ->where('filename','like',"%$search%")
            ->orWhere('uploader','like',"%$search%")
            ->orWhere('deletedBy','like',"%$search%")
            ->whereNotNull('deleted_at')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->paginate(10);*/

        $deletedFiles = DB::table('files')
            ->whereNotNull('deleted_at')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where(function ($query) use ($search){
                $query->where('filename','like',"%$search%")
                    ->orWhere('uploader','like',"%$search%")
                    ->orWhere('deletedBy','like',"%$search%");
            })
            ->paginate(10);

//        dd($deletedFiles);
        return view('files.billingRemoved')->with('deletedFiles',$deletedFiles)->with('month',$month)->with('year',$year)->with('search',$search);
    }

    public function billingFilesPost(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $search = null;

        $billings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->join('clients','files.clients_id','=','clients.id')
            ->select('clients.*','files.filename','files.month','files.year','files.created_at','files.uploader','files.storedFile')
            ->paginate();
//        dd($billings);

        return view('files.billingFiles')->with('billings',$billings)->with('month',$month)->with('year',$year)->with('search',$search);

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

        return redirect('billingRemoved')->with('success','Invoice restored');
    }

}
