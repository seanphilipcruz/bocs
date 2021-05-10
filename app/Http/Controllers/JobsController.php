<?php

namespace App\Http\Controllers;

use App\Job;
use Auth;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Validator;

class JobsController extends Controller
{
    public function index(Request $request) {
        $jobs = Job::where('is_active', 1)->get();

        foreach ($jobs as $job) {
            if ($job->is_active === 1) {
                $job->status = "<div class='text-success text-center'><i class='fas fa-circle'></i></div>";
            } else if ($job->is_active === 0) {
                $job->status = "<div class='text-danger text-center'><i class='fas fa-circle'></i></div>";
            }

            $job->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#update-job-modal' data-action='open' data-link='".route('jobs.show')."' data-id='".$job->id."' tooltip title='Update Advertiser' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                "   <a href='#delete-job-modal' data-action='open' data-link='".route('jobs.show')."' data-id='".$job->id."' tooltip title='Remove Advertiser' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                "</div>";
        }

        if($request->ajax()) {
            if($request['navigation']) {
                return view('webpages.jobs');
            }

            return $jobs;
        }

        return response()->json(['status' => 'error', 'message' => 'The webpage you were looking for wasn\'nt found'], 400);
    }

    public function show(Request $request) {
        $job = Job::findOrFail($request['id']);

        return response()->json(['job' => $job]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'job_description' => 'required',
            'level' => 'required'
        ]);

        if($validator->passes()) {
            $job = new Job();

            $job->fill($request->all());

            return response()->json(['status' => 'success', 'message' => 'A new job description has been created!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
    }

    public function update($id, Request $request) {
        $job = Job::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'job_description' => 'required',
            'level' => 'required'
        ]);

        if($validator->passes()) {
            $job->update($request->all());
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
    }

    public function delete($id) {
        $job = Job::findOrFail($id);

        // getting the user level
        $user_level = Auth::user()->Job->level;

        if($user_level === 1) {
            $job->delete();

            return response()->json(['status' => 'success', 'message' => 'A job description has been removed!']);
        }

        return response()->json(['status' => 'warning', 'message' => 'You don\'t have the administrative rights!']);
    }
}
