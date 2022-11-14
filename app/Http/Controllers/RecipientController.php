<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RecipientController extends Controller
{
    public function recipients(){
        $recipients = DB::table('recipients')->orderByDesc('id')->paginate(10);

        $url = request()->fullUrl();
        Session::put('data_url',$url);
        return view('recipient.recipients')->with('recipients',$recipients);
    }

    public function addRecipient(){
        return view('recipient.addRecipient');
    }

    public function storeRecipient(Request $request){
        $this->validate($request,[
            'company' => 'required',
            'email' => 'required',
        ],[
            'company.required' => 'Company name is required',
            'email.required' => 'Email is required'
        ]);

        $recipient = new Recipient([
            'recipient_name' => $request->company,
            'recipient_email' => $request->email,
            'created_by' => Auth::user()->name,
            'status' => 'Active',
        ]);

        $recipient->save();

        return redirect('recipients')->with('success','Recipient added successfully !');
    }

    public function editRecipient($id){

        $recipient = DB::table('recipients')
            ->where('id',$id)
            ->first();

        return view('recipient.editRecipient')->with('recipient',$recipient);
    }

    public function updateRecipient(Request $request){
        $this->validate($request,[
            'company' => 'required',
            'email' => 'required',
        ]);

        $recipient = Recipient::find($request->id);
        $recipient->recipient_name = $request->company;
        $recipient->recipient_email = $request->email;

        $recipient->save();

        if (Session('data_url')){
            return redirect(Session('data_url'))->with('success',"Recipient updated");
        }

        return redirect('recipients')->with('success','Recipient updated !');
    }

    public function removeRecipient($id){
        $recipient = Recipient::find($id);
        $recipient->delete();
        if (Session('data_url')){
            return redirect(Session('data_url'))->with('success',"Recipient deleted");
        }

        return redirect('recipients')->with('success','Recipient deleted !');
    }

    public function searchRecipient(Request $request){
        $search = $request->search;
        $recipients = DB::table('recipients')
            ->where('recipient_name','like',"%$search%")
            ->orWhere('recipient_email','like',"%$search%")
            ->paginate(10);

        $url = request()->fullUrl();
        Session::put('data_url',$url);

        return view('recipient.recipients')->with('recipients',$recipients)->with('search',$search);
    }



}
