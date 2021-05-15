<?php

namespace App\Http\Controllers;

use App\ContractRevision;
use App\EmployeeLogs;
use App\Job;
use Auth;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class JobsController extends Controller
{
    public function index(Request $request) {
        $jobs = Job::where('is_active', 1)->get();

        foreach ($jobs as $job) {
            if ($job->is_active === 1) {
                $job->status = "<div class='badge badge-success text-center'>Active</div>";
            } else if ($job->is_active === 0) {
                $job->status = "<div class='badge badge-danger text-center'>Inactive</div>";
            }

            $job->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#update-job-modal' data-action='open' data-link='".route('jobs.show')."' data-id='".$job->id."' tooltip title='Update Job' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                "   <a href='#delete-job-modal' data-action='open' data-link='".route('jobs.show')."' data-id='".$job->id."' tooltip title='Remove Job' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
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

            $job->save();

            $employee = Auth::user();

            $new_job = Job::latest()->first();

            $logs = new EmployeeLogs([
                'action' => 'Created a new job description named ' . $new_job->job_description,
                'employee_id' => $employee->id,
                'user_id' => $employee->id,
                'job_id' => $employee->Job->id
            ]);

            $logs->save();

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

        $employee = Auth::user();

        if($validator->passes()) {
            $job->update($request->all());

            $logs = new EmployeeLogs([
                'action' => 'Updated a job description named ' . $job->job_description,
                'employee_id' => $employee->id,
                'user_id' => $employee->id,
                'job_id' => $employee->Job->id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => $job->job_description . ' has been updated!']);
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
