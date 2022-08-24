<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function users(){
        $users = DB::table('users')->get();
        $search=null;
//        dd($users);
        return view('admin.users')->with('users',$users)->with('search',$search);
    }
    public function searchUsers(Request $request){
        $search = $request->search;
        $users = DB::table('users')
            ->where('name','like',"%$search%")
            ->orWhere('email','like',"%$search%")
            ->get();
        return view('admin.users')->with('users',$users)->with('search',$search);
    }
}
