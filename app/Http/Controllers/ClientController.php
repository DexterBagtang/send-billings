<?php

namespace App\Http\Controllers;

use App\Imports\ClientImport;
use App\Models\Client;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


//use Maatwebsite\Excel\Excel;

class ClientController extends Controller
{
    //---------------Clients---------------------------------------------------------------------------------------------
    public function index(){
//        $clients = DB::table('clients')
//            ->orderBy('id','desc')
////            ->paginate(50);
//            ->get();
        DB::connection()->enableQueryLog();
        $clients = DB::table('clients')
            ->orderBy('company')
            ->paginate(50);


        $duplicate = DB::table('clients')
            ->groupBy('contract_number','account_number')
            ->select('contract_number','account_number',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();
        $queries = DB::getQueryLog();
        foreach ($queries as $item) {
            $queriesAll[] = $item['query'];
        }
        $query = json_encode($queriesAll);

        $search = null;

        $url = request()->fullUrl();
        Session::put('data_url',$url);

        return view('clients.index')->with('clients',$clients)->with('duplicate',$duplicate)->with('search',$search)->with('url',$url);
    }

    //--------------Add Client-------------------------------------    //--------------Add Client-------------------------------------    //--------------Add Client-------------------------------------
    public function addClient(){
        return view('clients.addClient');
    }

    public function addedClient(Request $request){

        $this->validate($request,[
           'company'=>'required',
            'email'=>'required',
            'account_number'=>'required|max:8|min:8',
            'contract_number'=>'required|max:4|min:4',
            'incharge' => 'required',
            'email_incharge' => 'required',
        ],[
            'company.required' => 'Company is empty !',
            'email.required' => 'Email is empty !',
            'email.email' => 'Please enter a valid email',
            'account_number.required' => 'Account Number is required',
            'account_number.integer' => 'Invalid Account number',
            'account_number.max' => 'Account Number must not be greater than 8 digits',
            'account_number.min' => 'Account Number must be at least 8 digits',
            'contract_number.required' => 'Contract Number is required',
            'contract_number.integer' => 'Invalid Contract number',
            'contract_number.max' => 'Contract Number must not be greater than 4 digits',
            'contract_number.min' => 'Contract Number must be at least 4 digits'

        ]);
        //========== Checks for possible duplicate ======================//
        $checkDuplicate = DB::table('clients')->where('account_number',$request->account_number)
            ->where('contract_number',$request->contract_number)
            ->get();
        if (count($checkDuplicate) > 0){
            return back()
                ->withErrors(["Client with an account number of $request->account_number and contract number of $request->contract_number already exists in the database !"]);
        }
        //==============================================================//

        $client = new Client([
            'company' => $request->input('company'),
            'email' => $request->input('email'),
            'account_number' => $request->input('account_number'),
            'contract_number' => $request->input('contract_number'),
            'incharge' => $request->input('incharge'),
            'incharge_email' => $request->input('email_incharge'),
        ]);
        $client->save();

        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => $client,
            'module' => 'added client',
        ]);
        $logs->save();
//        dd($queries,$query);
        return redirect('clients')->with('success','Client added successfully');

    }

//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT-----------------

    public function editClient($id){
        $client = Client::find($id);
        $emails = explode(',',$client->email);

//        return response()->json([
//            'data' => $client
//        ]);
//        return view('clients.editClient',compact('client'));
        return view('clients.editClient')->with('client',$client)->with('emails',$emails);
    }



    public function editedClient(Request $request){


        //========== Checks for possible duplicate ======================//
        $checkDuplicate = DB::table('clients')
            ->where('account_number',$request->account_number)
            ->where('contract_number',$request->contract_number)
            ->first();
//        dd($checkDuplicate);

        if (isset($checkDuplicate)){
            if($request->id != $checkDuplicate->id){
                return back()
                    ->withErrors(["Client with an account number of $request->account_number and contract number of $request->contract_number already exists in the database !"]);
            }
        }

        //==============================================================//
        $email = implode(',',$request->email);
//        dd($request->email,$email);
        $client = Client::find($request->id);
        $client->company = $request->input('company');
//        $client->email = $request->input('email');
        $client->email = $email;
        $client->account_number = $request->input('account_number');
        $client->contract_number = $request->input('contract_number');
        $client->incharge = $request->input('incharge');
        $client->incharge_email = $request->input('incharge_email');

        $client->update();

        //========= System logs =======//
        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => $client,
            'module' => 'edited client',
        ]);
        $logs->save();
        //==================================//

        if (Session('data_url')){
            return redirect(Session('data_url'))->with('success','Client edited successfully');
        }

        return redirect('clients')->with('success','Client edited successfully');
    }

    public function importClient(Request $request){
        $validator = Validator::make($request->all(), [
            'csv'=>'required|max:5000',
            ],[
                'csv.required' => 'Upload a CSV file',
            ]);
        if ($validator->fails()){
            return back()->withErrors($validator,'import')->withInput();
        }
        $extension = $request->file('csv')->getClientOriginalExtension();
        if ($extension != "csv"){
            return back()->with('importError','Please upload only a csv file type');
        }

        try {
            Excel::import(new ClientImport(),$request->file('csv'));

        }catch (\Exception $e){
            $error =  $e->getMessage();
            return $error;
//            return redirect('addClient')->with('importError','Invalid CSV file!');
        }
//        Excel::import(new ClientImport(),$request->file('csv'));

//        dd($extension);
//        (new ClientImport)->import('users.xlsx', null, \Maatwebsite\Excel\Excel::XLSX);


        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => $request->csv,
            'module' => 'import client',
        ]);


        return redirect('clients')->with('success','Successfully added clients');
    }



    public function duplicateClient(){
        $clients = DB::table('clients')
            ->groupBy('contract_number','account_number')
            ->select('contract_number','account_number',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();
//        dd($clients);
        if (count($clients) < 1){
            return redirect('clients');
        }
        foreach ($clients as $client){
            $duplicates = DB::table('clients')->where('account_number','=',$client->account_number)->where('contract_number','=',$client->contract_number)->get('id');
            foreach ($duplicates as $duplicate){
                $ids[]=$duplicate->id;
            }
        }

        $duplicates = DB::table('clients')
            ->whereIn('id',$ids)
            ->orderByDesc('account_number')
            ->orderBy('contract_number')
            ->paginate(10);

//        dd($duplicates  );
        $search = null;

        $url = request()->fullUrl();
        Session::put('data_url',$url);

//        dd($clients,$data,/*$duplicates*/);
        return view('clients.duplicateClient')->with('duplicates',$duplicates)->with('search',$search);
    }
    public function searchDuplicateClient(Request $request){
        $search = $request->input('search');

        $clients = DB::table('clients')
            ->where('company','like',"%$search%")
            ->orWhere('account_number','like',"%$search%")
            ->orWhere('contract_number','like',"%$search%")
            ->orWhere('email','like',"%$search%")
            ->groupBy('contract_number')
            ->select('contract_number',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();
        if (count($clients) > 0){
            foreach ($clients as $client){
                $data[] = $client->contract_number;
            }
//
            $duplicates = DB::table('clients')
                ->whereIn('contract_number',$data)
                ->paginate(10);
        }else{
            $duplicates = DB::table('clients')
                ->whereNull('contract_number',null)
                ->paginate();
        }
        $url = request()->fullUrl();
        Session::put('data_url',$url);

//        dd($clients,$data,/*$duplicates*/);
        return view('clients.duplicateClient')->with('duplicates',$duplicates)->with('search',$search);

    }

    public function searchClient(Request $request){
        $search = $request->input('search');

        $clients = DB::table('clients')
            ->where('company','like',"%$search%")
            ->orWhere('account_number','like',"%$search%")
            ->orWhere('contract_number','like',"%$search%")
            ->orWhere('email','like',"%$search%")
            ->paginate(10);

        $duplicate = DB::table('clients')
            ->groupBy('contract_number')
            ->select('contract_number',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();
        $url = request()->fullUrl();
        Session::put('data_url',$url);

//        dd($clients);
        return view('clients.index')->with('clients',$clients)->with('duplicate',$duplicate)->with('search',$search);

    }

    public function removeClient($id){
        $client = DB::table('clients')->where('id',$id)->first();
        return view('clients.removeClient')->with('client',$client);
    }

    public function removedClient(Request $request){
        $client = Client::find($request->id);
        $client->disabled_at = now();
        $client->delete();

        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => $client,
            'module' => 'deleted client',
        ]);
        $logs->save();

        if (Session('data_url')){
            return redirect(Session('data_url'))->with('success',"You have removed $client->company with contract number of $client->contract_number");
        }
        return redirect('clients')->with('success',"You have removed $client->company with contract number of $client->contract_number");
    }

    public function removeClientDuplicate($id){
        $client = DB::table('clients')->where('id',$id)->first();
        return view('clients.removeClientDuplicate')->with('client',$client);
    }

    public function removedClientDuplicate(Request $request){
//        dd(Session('data_url'));
        $client = Client::find($request->id);
        $client->disabled_at = now();
        $client->delete();
        return redirect('duplicateClient')->with('success',"You have removed $client->company with contract number of $client->contract_number");

//        return back()->with('success',"You have removed $client->company with contract number of $client->contract_number");
    }

    public function viewClient($id){
        $client = DB::table('clients')->where('id',$id)->first();
        $emails = explode(",",$client->email);
//        dd($email);
        return view('clients.viewClient')->with('client',$client)->with('emails',$emails);
    }



}
