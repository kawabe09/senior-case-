<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timestamp;
use App\Models\Break_time;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function start(Request $request)
    {
        $punchIn = now();
        $user_id = Auth::id();

        $timestamp = new Timestamp;
        $timestamp->punchIn = $punchIn;
        $timestamp->user_id = $user_id;
        $timestamp->save();

        return view('index');
    }

    public function end(Request $request)
    {
        $punchOut = now();
        $user_id = Auth::id();

        $timestamp = Timestamp::where('user_id', $user_id)->latest()->first();

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

        return view('index');
    }

    public function rest()
    {
        $restIn=now();
        $user_id = Auth::id();
        $timestamp = Timestamp::where('user_id', $user_id)->latest()->first();
        $timestamp_id=$timestamp->id;

        $break = new Break_time;
        $break->restIn = $restIn;
        $break->timestamp_id = $timestamp_id;
        $break->save();

        return view('index');
    }

    public function rest_end()
    {
        $restOut=now();
        $user_id = Auth::id();

        $timestamp = Timestamp::where('user_id', $user_id)->latest()->first();

        $timestamp_id=$timestamp->id;
        $timestamp_rest_time=$timestamp->rest_time;

        $break = Break_time::where('timestamp_id', $timestamp_id)->latest()->first();

        $restIn=$break->restIn;
        $in_time=Carbon::parse($restIn);
        $out_time=Carbon::parse($restOut);
        $total=$in_time->diffInSeconds($out_time);

        $totalHours = floor($total / 3600);
        $remainingSeconds = $total % 3600;
        $totalMinutes = floor($remainingSeconds / 60);
        $totalSeconds = $remainingSeconds % 60;
        $total_time = sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);

        $break->restOut = $restOut;
        $break->total_time = $total_time;
        $break->save();

        if($timestamp_rest_time==null){
            $timestamp_rest_time=Carbon::parse($timestamp_rest_time ?? '00:00:00');
            $rest_time = $timestamp_rest_time->addHours($totalHours)->addMinutes($totalMinutes)-> addSeconds($totalSeconds);
        }
        else{
            $timestamp_rest_time = Carbon::parse($timestamp_rest_time);
            $rest_time = $timestamp_rest_time->addHours($totalHours)->addMinutes($totalMinutes)-> addSeconds($totalSeconds);
        }

        $timestamp->rest_time=$rest_time->format('H:i:s');
        $timestamp->save();

        return view('index');
    }

    public function data(Request $request)
    {
        /*$nowDate=Carbon::now();
        $interval=1;
        $startDate = $nowDate->subDays($interval);*/
        /*$startDate = $request->has('startDate') ? Carbon::parse($request->startDate):Carbon::now();
        if (!$request->has('startDate')) {
            $startDate = Carbon::now();
        }
        $startDate = $startDate->subDay();*/
        /*$startDate = Carbon::now();
        $interval = 1;
        if ($request->has('page')) {
            $startDate = $startDate->subDays(($request->page - 1) * $interval);
        }
        $timestamps = Timestamp::whereDate('punchIn', '=',$startDate)
            ->orderBy('punchIn', 'desc')
            ->paginate(5);*/
        $timestamps=Timestamp::Paginate(5);
        foreach($timestamps as $timestamp){
            $id=$timestamp->user_id;
            $users=User::where('id', $id)->first();
            $timestamp->user_id=$users->name;
            $punchIn=Carbon::parse($timestamp->punchIn);
            $punchOut=Carbon::parse($timestamp->punchOut);
            $timestamp->punchIn=$punchIn->format('H:i:s');
            $timestamp->punchOut=$punchOut->format('H:i:s');
            if($timestamp->rest_time==null){
                $timestamp->rest_time=Carbon::parse($timestamp->rest_time ?? '00:00:00')->format('H:i:s');
            }
        }
    return view('attendance',compact('timestamps'/*, 'startDate'*/));
    }
}