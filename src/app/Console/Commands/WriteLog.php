<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Timestamp;
/*use App\Models\Break_time;*/
use Carbon\Carbon;

class WriteLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work_end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '0時に強制的に勤務終了';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $timestamps = Timestamp::all();

            foreach($timestamps as $timestamp){
                if($timestamp->punchOut==null){
                    $punchOut = now();

                    $punchIn=$timestamp->punchIn;
                    $rest_time=$timestamp->rest_time;
                    $in_time=Carbon::parse($punchIn);
                    $out_time=Carbon::parse($punchOut);
                    $total=$in_time->diffInSeconds($out_time);

                    $totalHours = floor($total / 3600);
                    $remainingSeconds = $total % 3600;
                    $totalMinutes = floor($remainingSeconds / 60);
                    $totalSeconds = $remainingSeconds % 60;
                    $work_time = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);

                    if($rest_time==null){
                        $timestamp->punchOut = $punchOut;
                        $timestamp->work_time = $work_time;
                        $timestamp->save();
                    }
                    else{
                        $rest_time = Carbon::parse($rest_time);
                        $total_work=$rest_time->diffInSeconds($work_time);
                        $total_Hours = floor($total_work / 3600);
                        $remaining_Seconds = $total_work % 3600;
                        $total_Minutes = floor($remaining_Seconds / 60);
                        $total_Seconds = $remaining_Seconds % 60;
                        $work_time = sprintf('%02d:%02d:%02d', $total_Hours, $total_Minutes, $total_Seconds);

                        $timestamp->punchOut = $punchOut;
                        $timestamp->work_time = $work_time;
                        $timestamp->save();
                    }
                }
            }
    }
}
