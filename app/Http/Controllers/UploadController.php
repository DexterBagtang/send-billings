<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    public function upload(){
        return view('files.upload');
    }


    //------------Upload Generated Pdf ------------
    public function uploaded(Request $request){
        $this->validate($request,[
            'month' => 'required',
            'year' => 'required',
            'billing_file' => 'required',
        ]);
        $month = $request->input('month');
        $year = $request->input('year');
        $count = count($request->billing_file);

//        $upload = new Upload();
//        $upload->files_id = null;
//        $upload->uploader = Auth::user()->name;
//        $upload->fileNames = "null";
//        $upload->fileCount = $count;
//        $upload->month = $month;
//        $upload->year = $year;
//        $upload->save();



//

        if ($request->hasFile('billing_file')){
            foreach ($request->file('billing_file') as $file){
                $name = $file->getClientOriginalName();
                $a_no = substr($name,0,8);
                $namenoano = substr($name,8);
                $c_no = substr($namenoano,0,4);
                $file->move(public_path("billing_files/$month-$year"),$name);




                $client = Client::query()->where('account_number','=',$a_no)->where('contract_number','=',$c_no)->first();
//                dd($name,$a_no,$c_no,$client,Auth::user()->name);
                $bill_file = new File();
                $bill_file->filename = $name;
                $bill_file->clients_id = $client->id;
                $bill_file->month = $request->input('month');
                $bill_file->year = $request->input('year');
                $bill_file->uploader = Auth::user()->name;
                $bill_file->emailStatus = "not sent";
                $bill_file->save();
                $id = DB::table('files')->orderBy('id','desc')->first();
                $ids[] = $id->id;
                $filename[] = $bill_file->filename;

            }
            $store = json_encode($filename);
            $storeid = json_encode($ids);

//            dd($filename,$store,$count);
        $upload = new Upload();
        $upload->files_id = $storeid;
        $upload->uploader = Auth::user()->name;
        $upload->fileNames = $store;
        $upload->fileCount = $count;
        $upload->month = $month;
        $upload->year = $year;
        $upload->save();

        }
//        DB::table('uploads')->insert([
//                'files_id' => 1,
//                'uploader' => Auth::user()->name,
//                'fileNames' => "names",
//                'fileCount' => $count,
//                'month' => $month,
//                'year' => $year,
//                'created_at' => now(),
//                'updated_at' => now()
//            ]);



        return redirect('/uploadedFiles')->with('success',"Successfully uploaded $count files for the month of $month-$year");

        // ========================= Create demo files for testing =======================================//

//        $month = Carbon::parse($month)->format('m');
//        if ($request->hasFile('billing_file')){
//            $uploadedfile = $request->file('billing_file');
//            $name = $uploadedfile->getClientOriginalName();
//            $uploadedfile->move(public_path("file/$year-$month/"),$name);
//        }
//
//        $employees = DB::table('clients')->get();
////        $employees_count = DB::table('employees')->count();
//        foreach ($employees as $employee){
//            $fileName = $employee->account_number.$employee->contract_number.$year.$month.'.pdf';
//
//            $source = public_path()."/file/$year-$month/$name";
//            $copy = public_path()."/file/$year-$month/$fileName";
//            copy($source,$copy);
//
//            $file = new File();
//            $file->filename = $fileName;
//            $file->clients_id = $employee->id;
//            $file->month = $request->input('month');;
//            $file->year = $request->input('year');
//            $file->uploader = Auth::user()->name;
//            $file->emailStatus = "not sent";
//            $file->save();
//        }


    }

    public function uploadedFiles(){
        $uploads = DB::table('uploads')->orderBy('id','desc')->get();
//        dd($uploads);
        return view('files.uploadedFiles')->with('uploads',$uploads);
    }

    public function viewUploadedFiles($id){
        $upload = DB::table('uploads')
            ->where('id',$id)
            ->first();
        $filesId = json_decode($upload->files_id);
        $files = DB::table('files')
            ->whereIn('files.id',$filesId)
            ->join('clients','clients.id','=','files.clients_id')
            ->select('files.*','clients.email','clients.company','clients.account_number','clients.contract_number')
            ->get();
//        dd($files);
        return view('files.viewUploadedFiles')->with('upload',$upload)->with('files',$files);
    }


}