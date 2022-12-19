<?php

namespace App\Http\Controllers;

use App\Jobs\SendAnnouncementJob;
use App\Models\Announcement;
use App\Models\Composition;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{

    public function announcements(){
        $announcements = DB::table('compositions')->orderByDesc('id')->paginate(20);

//        dd($announcements);

        return view('announcement.view_announcements')->with('announcements',$announcements);
    }

    public function searchCompositions(Request $request){
        $search = $request->search;
        $announcements = DB::table('compositions')
            ->where('subject','like',"%$search%")
            ->orWhere('content','like',"%$search%")
            ->orWhere('attachment','like',"%$search%")
            ->paginate(20);
        return view('announcement.view_announcements')->with('announcements',$announcements)->with('search',$search);
    }

    public function view_compositions($id){
        $announcement = DB::table('compositions')->where('id','=',$id)->first();
//        dd($announcement);
        return view('announcement.view_compositions')->with('announcement',$announcement);

    }

    public function compose_announcements(){
        $clients = DB::table('clients')->groupBy('company')->select('company')->get();
//        dd($clients);
        return view('announcement.announcements')->with('clients',$clients);
    }

    public function sendAnnouncement(Request $request){
        $clientsCount = DB::table('clients')->count();
//        $clientsCount = 0;
        if ($clientsCount <= 0){
            return back()->withErrors(['You have to upload clients first!']);
        }
        $this->validate($request,[
            'subject' => 'required',
            'message' => 'required',
        ],[
            'message.required' => 'Body should not be empty !',
            'subject.required' => 'Subject should not be empty !'
        ]);
        $subject = $request->subject;
        $content = $request->message;

        if ($request->hasFile('attachments')){
            foreach ($request->file('attachments') as $file){
                $fileName = $file->getClientOriginalName();
                $file->move(public_path("announcement"),$fileName);
                $fileNames[] = $fileName;
            }
            $files = json_encode($fileNames);
        }else{
            $fileNames=null;
            $files =null;
        }
        $composed = new Composition([
           'subject' => $subject,
           'content' => $content,
           'attachment' => $files,
           'composed_by' => Auth::user()->name,
        ]);
        $composed->save();

        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => $composed,
            'module' => 'new composition added',
        ]);
        $logs->save();

        $compositions_id = $composed->id;


        $clients = DB::table('clients')->groupBy('email')->take(20)->get('email');

        foreach ($clients as $client) {
            $announcement = new Announcement([
                'compositions_id' => $compositions_id,
                'emailTo' => $client->email,
                'emailStatus' => 'For Sending',
                'emailBy' => Auth::user()->name,
            ]);
            $announcement->save();
        }
        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => $announcement,
            'module' => 'new announcements created',
        ]);
        $logs->save();

        $announcementsCount = DB::table('announcements')->take(20)->count();

        $all = $announcementsCount;
        $each = 5;
        $i = 1;
        $delaySecond = 0;

        for ($x=0; $x<=$all; $x+=$each){
            $announcements = DB::table('announcements')
                ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
                ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
                ->where('emailStatus','=','For Sending')
                ->take($each)
                ->get();
//            dd($announcements);

            $delaySeconds = $i + $delaySecond;

            foreach ($announcements as $announce){
                $data = [
                    'content' => $announce->content,
                ];
                $email = $announce->emailTo;
                $id = $announce->id;
//                $announcement = Announcement::query()->where('id',$id)->first();
//                dd($announcement);
                $emailJob = (new SendAnnouncementJob($data,$subject,$id,$email,$fileNames));
                dispatch($emailJob)->delay($delaySeconds)->onQueue('announcement');

                $update = Announcement::query()->where('id',$id)->first();
                $update->emailStatus = 'Sending';
                $update->update();

                $logs = new SystemLog([
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user' => Auth::user()->name,
                    'action' => $update,
                    'module' => 'announcement starts sending',
                ]);
                $logs->save();
            }
            $delaySecond = $i += 35;

        }
        return back()->with('success',"Announcement is now sending !");
    }

    public function sentAnnouncement(){
        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('emailStatus','=','Sent')
            ->orderByDesc('emailDate')
            ->paginate(25);
//        $announcements = Announcement::all()->composition->subject;
//        $composition = Composition::find(1)->announcement->emailTo;
//        dd($announcements);

//        $composition = Composition::find(1);
//        $announcement = $composition->emailTo;

//        dd($announcement);
        return view('announcement.sentAnnouncement')->with('announcements',$announcements);
    }

    public function readAnnouncement($id){
        $announcement = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('announcements.id','=',$id)
            ->first();
//        dd($announcement);
        $logs = new SystemLog([
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user' => Auth::user()->name,
            'action' => json_encode($announcement),
            'module' => 'view announcement',
        ]);
        $logs->save();
        return view('announcement.readAnnouncement')->with('announcement',$announcement);
    }

    public function sendingAnnouncement(){
        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('emailStatus','=','Sending')
            ->paginate(20);
//        dd($announcement);
        return view('announcement.sendingAnnouncement')->with('announcements',$announcements);
    }

    public function searchAnnouncement(Request $request){
        $status = $request->status;
        $search = $request->search;
        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('announcements.emailStatus','=',$status)
            ->where(function ($query) use ($search){
                $query->where('compositions.subject','like',"%$search%")
                    ->orWhere('compositions.content','like',"%$search%")
                    ->orWhere('announcements.emailTo','like',"%$search%")
                    ->orWhere('compositions.attachment','like',"%$search%");
            })
            ->paginate(25);

        if ($status == 'Sending'){
            $view = 'sendingAnnouncement';
        }
        elseif($status == 'Sent'){
            $view = 'sentAnnouncement';
        }
        elseif($status == 'Sending Error'){
            $view = 'failedAnnouncement';
        }
        else{
            $view = 'view_announcements';
        }

//        dd($announcement);
        return view("announcement.$view")->with('announcements',$announcements)->with('search',$search);
    }

    public function failedAnnouncement(){
        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('emailStatus','=','Sending Error')
            ->paginate(20);
//        dd($announcement);
        return view('announcement.failedAnnouncement')->with('announcements',$announcements);
    }

    public function deleteAnnouncement(Request $request){
        if (is_null($request->ids)){
            return back()->withErrors(['No items selected !']);
        }

        $announcements = DB::table('announcements')->whereIn('id',$request->ids)->get();
        if(!isset($announcements)){
            return back()->withErrors(['No items checked !']);
        }
        foreach ($announcements as $announcement) {
            $update = Announcement::find($announcement->id);
            $update->emailStatus = 'Removed';
            $update->save();

            $logs = new SystemLog([
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user' => Auth::user()->name,
                'action' => $update,
                'module' => 'announcement removed',
            ]);
            $logs->save();
        }
        return back()->with('success','Successfully Removed');
    }

    public function mark($status){
        $check = 'checked';
        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('emailStatus','=',$status)
            ->paginate(20);
//        dd($announcement);
        if ($status == 'Sending'){
            $view = 'sendingAnnouncement';
        }elseif($status == 'Sent'){
            $view = 'sentAnnouncement';
        }else{
            $view = 'failedAnnouncement';
        }

        return view("announcement.$view")->with('announcements',$announcements)->with('check',$check);
//        dd('mark all');
    }

    public function unmark($status){

        $check = null;
        $announcements = DB::table('announcements')
            ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
            ->leftJoin('compositions','announcements.compositions_id','=','compositions.id')
            ->where('emailStatus','=',$status)
            ->paginate(20);
//        dd($announcement);
        if ($status == 'Sending'){
            $view = 'sendingAnnouncement';
        }elseif($status == 'Sent'){
            $view = 'sentAnnouncement';
        }else{
            $view = 'failedAnnouncement';
        }
        return view("announcement.$view")->with('announcements',$announcements)->with('check',$check);
    }

    public function resendAnnouncement(Request $request){
        if (is_null($request->ids)){
            return back()->withErrors(['No items selected !']);
        }
//        dd($request->ids);



        $announcementsCount = DB::table('announcements')->whereIn('id',$request->ids)->count();
//        dd($announcementsCount);

        $all = $announcementsCount;
        $each = 5;
        $i = 1;
        $delaySecond = 0;

        for ($x=0; $x<=$all; $x+=$each){
            $announcements = DB::table('announcements')
                ->select('announcements.*','compositions.subject','compositions.content','compositions.attachment')
                ->leftJoin('compositions','announcements.compositions_id','=','compositions.id',)
                ->where('emailStatus','=','Sending Error')
                ->whereIn('announcements.id',$request->ids)
                ->take($each)
                ->get();
//            dd($announcements);

            $delaySeconds = $i + $delaySecond;

            foreach ($announcements as $announce){
                $data = [
                    'content' => $announce->content,
                ];
                $email = $announce->emailTo;
                $id = $announce->id;
                $subject = $announce->subject;
                if ($announce->attachment != null){
                    $fileNames = json_decode($announce->attachment);
                }else{
                    $fileNames = null;
                }
//                dd(json_decode($fileNames));
//                dd($announce);

//                $announcement = Announcement::query()->where('id',$id)->first();
//                dd($announcement);
                $emailJob = (new SendAnnouncementJob($data,$subject,$id,$email,$fileNames));
                dispatch($emailJob)->delay($delaySeconds)->onQueue('announcement');

                $update = Announcement::query()->where('id',$id)->first();
                $update->emailStatus = 'Sending';
                $update->update();

                $logs = new SystemLog([
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user' => Auth::user()->name,
                    'action' => $update,
                    'module' => 'start resending',
                ]);
                $logs->save();
            }
            $delaySecond = $i += 35;

        }
        return redirect('failedAnnouncement')->with('success',"Announcement is now sending !");
    }

    public function deleteComposition(Request $request){
        if (is_null($request->ids)){
            return back()->withErrors(['No items selected !']);
        }

        $announcements = DB::table('compositions')->whereIn('id',$request->ids)->get();
        if(!isset($announcements)){
            return back()->withErrors(['No items checked !']);
        }

        foreach ($announcements as $announcement) {
            $update = Composition::find($announcement->id);
//            $update->emailStatus = 'Removed';
            $update->delete();

            $logs = new SystemLog([
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user' => Auth::user()->name,
                'action' => $update,
                'module' => 'delete composition',
            ]);
            $logs->save();
        }
        return back()->with('success','Successfully Removed');
    }



}
