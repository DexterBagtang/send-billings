<?php

namespace App\Http\Controllers;

use App\Jobs\SendAnnouncementJob;
use App\Models\Announcement;
use App\Models\Composed;
use App\Models\Composition;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function announcements(){
        $clients = DB::table('clients')->groupBy('company')->select('company')->get();
//        dd($clients);
        return view('announcement.announcements')->with('clients',$clients);
    }

    public function sendAnnouncement(Request $request){
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
            $fileNames[]=null;
            $files =null;
        }
        $composed = new Composition([
           'subject' => $subject,
           'content' => $content,
           'attachment' => $files,
           'composed_by' => Auth::user()->name,
        ]);
        $composed->save();
//        return $fileNames;


//        $currentDate = date('Y-m-d');


        $clients = DB::table('clients')->groupBy('email')->take(10)->get('email');

        foreach ($clients as $client) {
            $announcement = new Announcement([
               'subject' => $subject,
                'content' => $content,
                'attachment' => $files,
                'emailTo' => $client->email,
                'emailStatus' => 'For Sending',
                'emailBy' => Auth::user()->name,
//                'emailDate' => now(),
            ]);
            $announcement->save();
        }

        $announcementsCount = DB::table('announcements')->take(10)->count();

        $all = $announcementsCount;
        $each = 5;
        $i = 1;
        $delaySecond = 0;

        for ($x=0; $x<=$all; $x+=$each){
            $announcements = DB::table('announcements')
                ->where('emailStatus','=','For Sending')
//                ->where('emailDate','=',$currentDate)
                ->take($each)
                ->get();
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
            }
            $delaySecond = $i += 35;

        }
        return back()->with('success',"Announcement is now sending !");
    }

    public function sentAnnouncement(){
        $announcements = DB::table('announcements')
            ->where('emailStatus','=','Sent')
            ->orderByDesc('id')
            ->paginate(25);

//        dd($announcements);
        return view('announcement.sentAnnouncement')->with('announcements',$announcements);
    }

    public function readAnnouncement($id){
        $announcement = DB::table('announcements')->where('id','=',$id)->first();
//        dd($announcement);
        return view('announcement.readAnnouncement')->with('announcement',$announcement);
    }

    public function sendingAnnouncement(){
        $announcement = DB::table('announcements')->where('emailStatus','=','Sending')->get();
        dd($announcement);
    }

    public function searchAnnouncement(Request $request){
        $search = $request->search;
        $announcements = DB::table('announcements')
            ->where(function ($query) use ($search){
                $query->where('subject','like',"%$search%")
                    ->orWhere('content','like',"%$search%")
                    ->orWhere('emailTo','like',"%$search%")
                    ->orWhere('attachment','like',"%$search%");
            })
            ->paginate(25);
//        dd($announcement);
        return view('announcement.sentAnnouncement')->with('announcements',$announcements)->with('search',$search);
    }



}
