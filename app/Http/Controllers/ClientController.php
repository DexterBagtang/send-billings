<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    //---------------Clients----------------------------
    public function index(){
        $clients = DB::table('clients')->get();
        return view('clients.index')->with('clients',$clients);
    }
}
