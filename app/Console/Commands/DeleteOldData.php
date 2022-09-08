<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\Upload;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old records from the database ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('<fg=green;>Please wait...</>');
        $output = DB::table('files')->where('created_at','<=', now()->subMonths(3))->get();
//        $output = DB::table('files')/*->where('created_at','<=', now()->subMinutes(2))*/->get();
//        dd($output);
//        $output = DB::table('files')->get();
        $count = count($output);
        if ($count < 1){
            $this->line('<fg=green;>No old files detected !</>');
//            echo "No files detected";
        }else{
            foreach($output as $id){
                $file = File::find($id->id);
                $stored_file = public_path("billing_files/$id->month-$id->year/$id->storedFile");
                try {
                    unlink($stored_file);
                }catch (\Exception $exception){
                    $this->line('wala');
                }
                $file->forceDelete();
            }
            $this->line("<fg=green>$count old files deleted !</>");
        }
        $output2 = DB::table('uploads')->where('created_at','<=' , now()->subMonths(3))->select('id')->get();
        $count1 = count($output2);
        if ($count1 < 1){
            $this->line('<fg=green;>No old uploads detected !</>');
        }else{
            foreach($output2 as $ids){
                $file = Upload::find($ids->id);
                $file->forceDelete();
            }
            $this->line("<fg=green> $count1 old uploads deleted !</>");
        }
        return 0;
    }
}
