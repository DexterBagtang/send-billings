<?php

namespace App\Http\Controllers;

use _PHPStan_9a6ded56a\Nette\Neon\Exception;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function dashboard(){

        $month = now()->format('F');
        $year = now()->format('Y');

        $clientsCount = DB::table('clients')->count();
        $billingsCount = DB::table('files')
            ->whereNull('deleted_at')
            ->count();

        $monthBillings = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->whereNull('deleted_at')
            ->count();

        $monthBillingSent = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sent')
            ->count();

        $monthBillingSending = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending')
            ->count();

        $monthBillingFailed = DB::table('files')
            ->where('month','=',$month)
            ->where('year','=',$year)
            ->where('emailStatus','=','sending error')
            ->count();

        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('emailStatus','=','Sent')
            ->orderByDesc('id')
            ->count();

        $time = date('H');
        if ($time < 12){
            $greet = "Good morning";
        }elseif($time >= 12 && $time < 17){
            $greet = "Good afternoon";
        }elseif($time >= 17 && $time < 19){
            $greet = "Good evening";
        }else{
            $greet = "Good night";
        }

//        dd($greet);

        return view('index2')
            ->with('month',$month)
            ->with('year',$year)
            ->with('monthBillings',$monthBillings)
            ->with('sent',$monthBillingSent)
            ->with('sending',$monthBillingSending)
            ->with('failed',$monthBillingFailed)
            ->with('clientsCount',$clientsCount)
            ->with('billingsCount',$billingsCount)
            ->with('greet',$greet)
            ->with('announcements',$announcements);

    }

    public function account(){
        $user = DB::table('users')->where('id','=',Auth::user() -> id)->first();
//        dd($user);

        return view('account.account')->with('user',$user);
    }

    public function uploadProfile(Request $request)
    {

        $this->validate($request,[
           'profile_picture' => 'required'
        ]);

        if ($request->hasFile('profile_picture')){
            $profile_picture = $request->file('profile_picture');
            $profile_name = $profile_picture->getClientOriginalName();
            $profile_picture->move(public_path("profile"),$profile_name);

            $user = User::find(Auth::user() -> id);
            $user->profile_picture = $profile_name;
            $user->update();

            $logs = new SystemLog([
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user' => Auth::user()->name,
                'action' => $user,
                'module' => 'uploaded new profile picture',
            ]);
            $logs->save();
        }


        return back()->with('success','Profile picture uploaded');
    }

    public function changePassword(){
        return view('account.change_password');
    }

    public function updatePassword(Request $request){
        $this->validate($request,[
            'currentPassword' => 'required',
            'newPassword' => 'required|confirmed'
        ]);

        if (!(Hash::check($request->get('currentPassword'), Auth::user()->password))) {
            // The passwords matches
            return back()->withErrors([ "Your current password does not matches with the password you provided. Please try again."]);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $user->update();

        Auth::guard('web')->logout();
        $request->session()->invalidate();



        $request->session()->regenerateToken();



        return redirect('login')->with('success','Password changed successfully !');
    }

}
