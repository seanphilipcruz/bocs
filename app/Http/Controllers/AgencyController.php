<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Agency;
use App\AgencyAdvertiserLogs;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgencyController extends Controller
{
    public function index(Request $request) {
        $agencies = Agency::orderBy('agency_name')->get();

        foreach ($agencies as $agency) {
            if ($agency->is_active === 1) {
                $agency->status = "<div class='badge badge-success text-center'>Active</div>";
            } else if ($agency->is_active === 0) {
                $agency->status = "<div class='badge badge-danger text-center'>Inactive</div>";
            } else {
                $agency->status = "<div class='badge badge-primary text-center'>Undefined</div>";
            }

            if($agency->kbp_accredited === 1) {
                $agency->kbp_status = "<span class='badge badge-success text-center'>Accredited</span>";
            } else if($agency->kbp_accredited === 0) {
                $agency->kbp_status = "<span class='badge badge-warning text-center'>Non-Accredited</span>";
            } else {
                $agency->kbp_status = "<span class='badge badge-danger text-center'>Undefined</span>";
            }

            if($agency->address === null || $agency->address === '' || $agency->address === "") {
                $agency->address = "<div class='badge badge-danger text-center'>Undefined</div>";
            }

            if($agency->contact_number === null || $agency->contact_number === '' || $agency->contact_number === "") {
                $agency->contact_number = "<div class='badge badge-danger text-center'>Undefined</div>";
            }

            $agency->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#update-agency-modal' data-action='open' data-link='".route('agencies.show')."' data-id='".$agency->agency_code."' tooltip title='Update Agency' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                "   <a href='#delete-agency-modal' data-action='open' data-link='".route('agencies.show')."' data-id='".$agency->agency_code."' tooltip title='Remove Agency' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                "</div>";
        }

        if($request->ajax()) {
            if($request->has('select')) {
                $option = "";

                foreach($agencies as $agency) {
                    $option .= "<option value='".$agency->agency_code."'>".$agency->agency_name."</option>";
                }

                return response()->json(['agencies' => $option]);
            }

            if($request->has('search')) {
                $search_query = Agency::where('agency_name', '=', $request['value']);

                if($search_query->count() >= 1) {
                    return $search_query->get()->first();
                } else {
                    return response()->json(['status' => 'non-existing']);
                }
            }

            if($request->has('navigation')) {
                return view('webpages.agencies');
            }
            return $agencies;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }

    public function show(Request $request) {
        if($request->ajax()) {
            $agency = Agency::findOrFail($request->id);

            if($request->has('kbp_verification')) {
                if($agency->kbp_accredited === 1) {
                    $agency->kbp_status = "<span class='badge badge-success'>Accredited</span>";
                } else if($agency->kbp_accredited === 0) {
                    $agency->kbp_status = "<span class='badge badge-warning'>Non-Accredited</span>";
                } else {
                    $agency->kbp_status = "<span class='badge badge-danger'>Undefined</span>";
                }

                return response()->json(['agency' => $agency]);
            }

            return response()->json(['agency' => $agency]);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'agency_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'kbp_accredited' => 'required',
        ]);

        if($validator->passes()) {
            $request['is_active'] = 1;

            Agency::create($request->all());

            $new_agency = Agency::latest()->get()->first();

            $logs = new AgencyAdvertiserLogs([
                'agency_id' => $new_agency['agency_code'],
                'action' => 'Added a new agency named ' . $new_agency['agency_name'],
                'employee_id' => Auth::user()->id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'An agency has been created!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()],400);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'agency_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'kbp_accredited' => 'required'
        ]);

        if($validator->passes()) {
            $agency = Agency::findOrFail($id);

            if($agency['agency_name'] != $request['agency_name']) {
                $logs = new AgencyAdvertiserLogs([
                    'agency_id' => $agency['agency_code'],
                    'action' => 'Updated the agency name from ' . $agency['agency_name'] . ' to ' . $request['agency_name'],
                    'employee_id' => Auth::user()->id
                ]);

                $logs->save();
            }

            if($agency['contact_number'] != $request['contact_number']) {
                $logs = new AgencyAdvertiserLogs([
                    'agency_id' => $agency['agency_code'],
                    'action' => 'Updated the agency contact number from ' . $agency['contact_number'] . ' to ' . $request['contact_number'],
                    'employee_id' => Auth::user()->id
                ]);

                $logs->save();
            }

            if($agency['address'] != $request['address']) {
                $logs = new AgencyAdvertiserLogs([
                    'agency_id' => $agency['agency_code'],
                    'action' => 'Updated the agency address from ' . $agency['address'] . ' to ' . $request['address'],
                    'employee_id' => Auth::user()->id
                ]);

                $logs->save();
            }

            if($agency['kbp_accredited'] != $request['kbp_accredited']) {
                if($request['kbp_accredited'] === "0") {
                    $logs = new AgencyAdvertiserLogs([
                        'agency_id' => $agency['agency_code'],
                        'action' => 'Set the kbp accreditation of ' . $agency['agency_name'] . ' to unaccredited',
                        'employee_id' => Auth::user()->id
                    ]);

                    $logs->save();
                }

                if($request['kbp_accredited'] === "1") {
                    $logs = new AgencyAdvertiserLogs([
                        'agency_id' => $agency['agency_code'],
                        'action' => 'Set the kbp accreditation of ' . $agency['agency_name'] . ' to accredited',
                        'employee_id' => Auth::user()->id
                    ]);

                    $logs->save();
                }
            }

            if($agency['is_active'] != $request['is_active']) {
                if($request['is_active'] === "0") {
                    $logs = new AgencyAdvertiserLogs([
                        'agency_id' => $agency['agency_code'],
                        'action' => 'Set the status of ' . $agency['agency_name'] . ' to inactive',
                        'employee_id' => Auth::user()->id
                    ]);

                    $logs->save();
                }

                if($request['is_active'] === "1") {
                    $logs = new AgencyAdvertiserLogs([
                        'agency_id' => $agency['agency_code'],
                        'action' => 'Set the status of ' . $agency['agency_name'] . ' to active',
                        'employee_id' => Auth::user()->id
                    ]);

                    $logs->save();
                }
            }

            $agency->update($request->all());

            return response()->json(['status' => 'success', 'message' => 'An agency has been updated!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()],400);
    }

    public function delete($id) {
        $agency = Agency::findOrFail($id);

        $user_level = Auth::user()->Job->level;

        if($user_level === 1) {
            $logs = new AgencyAdvertiserLogs([
                'agency_id' => $agency['agency_code'],
                'action' => 'Tried to delete '. $agency['agency_name'] . ' but we don\'t delete data here.',
                'employee_id' => Auth::user()->id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'An agency has been removed!']);
        }

        return response()->json(['status' => 'warning', 'message' => 'You don\'t have the administrative rights!']);
    }
}
