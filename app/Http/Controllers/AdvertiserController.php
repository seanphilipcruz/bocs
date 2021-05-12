<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\AgencyAdvertiserLogs;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertiserController extends Controller
{
    public function index(Request $request) {
        $advertisers = Advertiser::all();

        foreach ($advertisers as $advertiser) {
            if ($advertiser->is_active === 1) {
                $advertiser->status = "<div class='badge badge-success text-center'>Active</div>";
            } else if ($advertiser->is_active === 0) {
                $advertiser->status = "<div class='badge badge-danger text-center'>Inactive</div>";
            }

            $advertiser->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#update-advertiser-modal' data-action='open' data-link='".route('advertisers.show')."' data-id='".$advertiser->advertiser_code."' tooltip title='Update Advertiser' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                "   <a href='#delete-advertiser-modal' data-action='open' data-link='".route('advertisers.show')."' data-id='".$advertiser->advertiser_code."' tooltip title='Remove Advertiser' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                "</div>";
        }

        if($request->ajax()) {
            if($request->has('navigation')) {
                return view('webpages.advertisers');
            }

            return $advertisers;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }

    public function show(Request $request) {
        if($request->ajax()) {
            $advertiser = Advertiser::findOrFail($request->id);

            return response()->json(['advertiser' => $advertiser]);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'advertiser_name' => 'required'
        ]);

        if ($validator->passes()) {
            $request['is_active'] = 1;

            Advertiser::create($request->all());

            $new_advertiser = Advertiser::latest()->get()->first();

            $logs = new AgencyAdvertiserLogs([
                'advertiser_id' => $new_advertiser['advertiser_code'],
                'action' => 'Added a new advertiser named ' . $new_advertiser['advertiser_name'],
                'employee_id' => Auth::user()->id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'An advertiser has been created!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'advertiser_name' => 'required'
        ]);

        if($validator->passes()) {
            $advertiser = Advertiser::findOrFail($id);

            if($advertiser['advertiser_name'] != $request['advertiser_name']) {
                $logs = new AgencyAdvertiserLogs([
                    'advertiser_id' => $advertiser['advertiser_code'],
                    'action' => 'Updated the advertiser name from ' . $advertiser['advertiser_name'] . ' to ' . $request['advertiser_name'],
                    'employee_id' => Auth::user()->id
                ]);

                $logs->save();
            }

            if($advertiser['is_active'] != $request['is_active']) {
                if($request['is_active'] === "0") {
                    $logs = new AgencyAdvertiserLogs([
                        'advertiser_id' => $advertiser['advertiser_code'],
                        'action' => 'Set the status of ' . $advertiser['advertiser_name'] . ' to inactive',
                        'employee_id' => Auth::user()->id
                    ]);

                    $logs->save();
                }

                if($request['is_active'] === "1") {
                    $logs = new AgencyAdvertiserLogs([
                        'advertiser_id' => $advertiser['advertiser_code'],
                        'action' => 'Set the status of ' . $advertiser['advertiser_name'] . ' to active',
                        'employee_id' => Auth::user()->id
                    ]);

                    $logs->save();
                }
            }

            $advertiser->update($request->all());

            return response()->json(['status' => 'success', 'message' => 'An advertiser has been updated!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
    }

    public function delete($id) {
        $advertiser = Advertiser::findOrFail($id);

        $user_level = Auth::user()->Job->level;

        if($user_level === 1) {
            $logs = new AgencyAdvertiserLogs([
                'advertiser_id' => $advertiser['advertiser_code'],
                'action' => 'Tried to delete '. $advertiser['advertiser_name'] . ' but we don\'t delete data here.',
                'employee_id' => Auth::user()->id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'An advertiser has been removed!']);
        }

        return response()->json(['status' => 'warning', 'message' => 'You don\'t have the administrative rights!']);
    }
}
