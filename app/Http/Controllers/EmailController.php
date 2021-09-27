<?php

namespace App\Http\Controllers;

use App\Jobs\EmailSend;
use App\Mail\SendEmail;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            "subject" => 'required',
            "body" => 'required',
            "to" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => $validator->errors()->first()], 200);

        } else {
            $delay = $request->schedule;
            $schedule = $request->schedule;
            if ($delay) {
                $delay = Carbon::parse($delay);
            } else {
                $schedule = "immediate delivery";
                $delay = Carbon::now();
            }
            $job = new EmailSend($request->all());
            $job = $job->delay($delay);
            $q = app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
            return response()->json(["success" => true, "job_id" => $q, "scheduled_to" => $schedule], 200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $j = Job::find($id);
        if ($j) {
            $j->delete();
        }
        return response()->json(["success" => true], 200);
    }
}
