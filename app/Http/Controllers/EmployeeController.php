<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeLogs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('Job')->get();

        foreach ($employees as $employee) {
            if ($employee->is_active === 1) {
                $employee->status = "<div class='badge badge-success text-center'>Active</div>";
            } else if ($employee->is_active === 0) {
                $employee->status = "<div class='badge badge-danger text-center'>Inactive</div>";
            }

            $employee->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#update-employee-modal' data-action='open' data-link='".route('employees.show')."' data-id='".$employee->id."' tooltip title='Update Employee' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                "   <a href='#change-password-modal' data-action='open' data-link='".route('employees.show')."' data-id='".$employee->id."' tooltip title='Change Password' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-lock'></i></a>" .
                "   <a href='#delete-employee-modal' data-action='open' data-link='".route('employees.show')."' data-id='".$employee->id."' tooltip title='Remove Employee' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                "</div>";
        }

        if ($request->ajax()) {
            if($request->has('navigation')) {
                return view('webpages.employees');
            }
            return $employees;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }

    public function show(Request $request) {
        if($request->ajax()) {
            $employee = Employee::with('Job')->findOrFail($request->id);

            return response()->json(['employee' => $employee]);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'date_of_birth' => 'required',
            'username' => 'required',
            'job_id' => 'required'
        ]);

        if($validator->passes()) {
            if($request['nickname'] === null || $request['nickname'] === '') {
                $request['nickname'] = $request['first_name'];
            }

            $request['is_active'] = 1;

            $request['password'] = Hash::make(date('mdy', strtotime($request['date_of_birth'])));

            Employee::create($request->all());

            $latest_employee = Employee::latest()->get()->first();

            $this->Log('Added an Employee named '. $latest_employee->first_name . ' ' . $latest_employee->last_name . '.', $latest_employee->id, Auth::user()->id);

            return response()->json(['status' => 'success', 'message' => 'An employee has been created!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()],400);
    }

    public function update($id, Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
           'last_name' => 'required',
           'first_name' => 'required',
           'date_of_birth' => 'required',
           'job_id' => 'required',
           'is_active' => 'required'
        ]);

        if($validator->passes()) {
            $employee = Employee::findOrFail($id);

            $employee->update($request->all());

            $this->Log('Updated '. $employee->first_name . '\'s Information', $employee->id, Auth::user()->id);

            return response()->json(['status' => 'success', 'message' => 'An employee\'s information has been updated!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()],400);
    }

    public function delete($id): JsonResponse {
        $employee = Employee::findOrFail($id);

        $user_level = Auth::user()->Job->level;

        if($user_level === 1) {
            $this->Log('Attempted to delete an Employee Data', $employee->id, Auth::user()->id);

            return response()->json(['status' => 'success', 'message' => 'An employee has been removed!']);
        }

        $this->Log('Attempted to delete an Employee Data', $employee->id, Auth::user()->id);

        return response()->json(['status' => 'warning', 'message' => 'You don\'t have the administrative rights!']);
    }

    public function ChangePassword($id, Request $request) {
        $employee = Employee::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'password' => ['confirmed', 'min:6', 'required']
        ]);

        if($validation->passes()) {
            if($request->ajax()) {
                $current_password = $employee['password'];

                $verify = Hash::check($request['current_password'], $current_password);

                if($verify) {
                    $request['password'] = Hash::make($request['password']);

                    $employee['password'] = $request['password'];

                    $employee->update();

                    $this->Log('Changed '. $employee->first_name .'\'s password', $employee->id, Auth::user()->id);

                    return response()->json(['status' => 'success', 'message' => 'Password successfully changed!']);
                }

                $this->Log('Attempted to change an Employee\'s Password', $employee->id, Auth::user()->id);

                return response()->json(['status' => 'error', 'message' => 'Passwords do not match!']);
            }
        }

        return response()->json(['status' => 'error', 'message' => $validation->errors()->all()],400);
    }


    public function request(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'date_of_birth' => 'required',
            'nickname' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if($validator->passes()) {
            $rx931 = preg_match('/rx931.com/', $request['username']);
            $bt995 = preg_match('/monsterdavao.com/', $request['username']);
            $bt1059 = preg_match('/monstercebu.com/', $request['username']);

            $request['is_active'] = 0;

            $birthdate = date('mdy', strtotime($request['date_of_birth']));

            $request['password'] = Hash::make($birthdate);

            if($rx931 == 1) {
                Employee::create($request->all());
            } else if($bt995 == 1) {
                Employee::create($request->all());
            } else if($bt1059 == 1) {
                Employee::create($request->all());
            } else {
                return response()->json(['status' => 'error', 'message' => 'The email provided is not affiliated with this company']);
            }

            return response()->json(['status' => 'success', 'message' => 'Request has been sent, you will be notified via Email.']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()],400);
    }

    private function Log($action, $employee_id, $user_id) {
        if($action && $employee_id && $user_id) {
            EmployeeLogs::create([
                'action' => $action,
                'employee_id' => $employee_id,
                'user_id' => $user_id,
                'job_id' => Auth::user()->job_id
            ]);
        }
    }
}
