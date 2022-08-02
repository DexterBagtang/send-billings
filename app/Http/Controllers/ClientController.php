<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    //---------------Clients----------------------------
    public function index(){
        $clients = DB::table('clients')
            ->orderBy('id','desc')
            ->get();
        return view('clients.index')->with('clients',$clients);
    }

    //--------------Add Client--------------------------
    public function addClient(){
        return view('clients.addClient');
    }

    public function addedClient(Request $request){
        $this->validate($request,[
           'company'=>'required',
            'email'=>'required',
            'account_number'=>'required',
            'contract_number'=>'required',
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

    public function editClient($id){
        $client = Client::find($id);
        return view('clients.editClient',compact('client'));
//        return view('clients.editClient')->with('client',$client);
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

}
