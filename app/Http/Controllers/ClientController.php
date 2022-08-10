<?php

namespace App\Http\Controllers;

use App\Imports\ClientImport;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;

//use Maatwebsite\Excel\Excel;

class ClientController extends Controller
{
    //---------------Clients---------------------------------------------------------------------------------------------
    public function index(){
        $clients = DB::table('clients')
            ->orderBy('id','desc')
            ->get();
        return view('clients.index')->with('clients',$clients);
    }

    //--------------Add Client-------------------------------------    //--------------Add Client-------------------------------------    //--------------Add Client-------------------------------------
    public function addClient(){
        return view('clients.addClient');
    }

    public function addedClient(Request $request){
        $this->validate($request,[
           'company'=>'required',
            'email'=>['required','email'],
            'account_number'=>'required',
            'contract_number'=>'required',
        ],[
            'company.required' => 'Company is empty !',
            'email.required' => 'Email is empty !',
            'email.email' => 'Please enter a valid email',

        ]);

        $client = new Client([
            'name' => $request->input('company'),
            'email' => $request->input('email'),
            'account_number' => $request->input('account_number'),
            'contract_number' => $request->input('contract_number'),
            'contact' => $request->input('contact'),
            'company' => $request->input('company'),
        ]);
        $client->save();

        return redirect('clients')->with('success','Client added successfully');

    }

//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT------------------//---------EDIT CLIENT-----------------

    public function editClient($id){
        $client = Client::find($id);
//        return response()->json([
//            'data' => $client
//        ]);
//        return view('clients.editClient',compact('client'));
        return view('clients.editClient')->with('client',$client);
    }



    public function editedClient(Request $request){
        $client = Client::find($request->id);
        $client->company = $request->input('company');
        $client->email = $request->input('email');
        $client->contact = $request->input('contact');
        $client->account_number = $request->input('account_number');
        $client->contract_number = $request->input('contract_number');

        $client->update();

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



}
