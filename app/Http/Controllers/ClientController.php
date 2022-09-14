<?php

namespace App\Http\Controllers;

use App\Imports\ClientImport;
use App\Models\Client;
use Illuminate\Http\Request;
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
        $clients = DB::table('clients')->orderByDesc('id')->paginate(10);

        $duplicate = DB::table('clients')
            ->groupBy('contract_number')
            ->select('contract_number',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();
        $search = null;

        $url = request()->fullUrl();
        Session::put('data_url',$url);


//        $clients = DB::table('clients')->simplePaginate();

//        dd($clients);
        return view('clients.index')->with('clients',$clients)->with('duplicate',$duplicate)->with('search',$search)->with('url',$url);
    }

    //--------------Add Client-------------------------------------    //--------------Add Client-------------------------------------    //--------------Add Client-------------------------------------
    public function addClient(){
        return view('clients.addClient');
    }

    public function addedClient(Request $request){
//        $emails = explode(',',$request->email);
//        $request->emails = $emails;

//        dd($request->email,$emails);

        $this->validate($request,[
           'company'=>'required',
            'email'=>'required',
            'account_number'=>'required',
            'contract_number'=>'required',
        ],[
            'company.required' => 'Company is empty !',
            'email.required' => 'Email is empty !',
            'email.email' => 'Please enter a valid email',
            'account_number.required' => 'Account Number is required',
            'contract_number.required' => 'Contract Number is required'
        ]);

        $client = new Client([
            'name' => $request->input('company'),
            'email' => $request->input('email'),
            'account_number' => $request->input('account_number'),
            'contract_number' => $request->input('contract_number'),
            'contact' => $request->input('email'),
            'company' => $request->input('company'),
        ]);
        $client->save();

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
        $email = implode(',',$request->email);
//        dd($request->email,$email);
        $client = Client::find($request->id);
        $client->company = $request->input('company');
//        $client->email = $request->input('email');
        $client->email = $email;
        $client->contact = $request->input('company');
        $client->account_number = $request->input('account_number');
        $client->contract_number = $request->input('contract_number');

        $client->update();
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
            return redirect('addClient')->with('importError','Invalid CSV file!');
        }
//        Excel::import(new ClientImport(),$request->file('csv'));

//        dd($extension);
//        (new ClientImport)->import('users.xlsx', null, \Maatwebsite\Excel\Excel::XLSX);




        return redirect('clients')->with('success','Successfully added clients');
    }



    public function duplicateClient(){
        $clients = DB::table('clients')
            ->groupBy('contract_number')
            ->select('contract_number',DB::raw('count(*) as count'))
            ->having('count','>','1')
            ->get();
        if (count($clients) < 1){
            return redirect('clients');
        }
        foreach ($clients as $client){
            $data[] = $client->contract_number;
        }

//
        $duplicates = DB::table('clients')
            ->whereIn('contract_number',$data)
            ->orderByDesc('contract_number')
            ->paginate(10);
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
