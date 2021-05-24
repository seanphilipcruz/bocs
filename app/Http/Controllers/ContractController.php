<?php

namespace App\Http\Controllers;

use App\AccountExecutiveLogs;
use App\Advertiser;
use App\Agency;
use App\Contract;
use App\ContractRevision;
use App\Employee;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    public function index(Request $request) {
        $executive = Auth::user()->id;
        $user_level = Auth::user()->Job->level;

        if($user_level === "2") {
            $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                ->where('bo_type', '=', 'normal')
                ->where('is_active', '=', '1')
                ->where('ae', '=', $executive)
                ->whereYear('created_at', date('Y'))
                ->orderBy('created_at')
                ->get();

            if($request['inactive']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'normal')
                    ->where('is_active', '=', '0')
                    ->where('ae', '=', $executive)
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['parent']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('is_active', '=', '1')
                    ->where('ae', '=', $executive)
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_parent']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('is_active', '=', '0')
                    ->where('ae', '=', $executive)
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['child_bo']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '1')
                    ->where('ae', '=', $executive)
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_child_bo']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '0')
                    ->where('ae', '=', $executive)
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }
        } else {
            $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                ->where('bo_type', '=', 'normal')
                ->where('is_active', '=', '1')
                ->whereYear('created_at', date('Y'))
                ->orderBy('created_at')
                ->get();

            if($request['inactive']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'normal')
                    ->where('is_active', '=', '0')
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['parent']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('is_active', '=', '1')
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_parent']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('is_active', '=', '0')
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['child_bo']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '1')
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_child_bo']) {
                $contracts = Contract::with('Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '0')
                    ->whereYear('created_at', date('Y'))
                    ->orderBy('created_at')
                    ->get();
            }
        }

        foreach ($contracts as $contract) {
            // getting the radio stations by breaking down the data from the string
            $manila = preg_match('/DWRX Manila;/', $contract['station']);
            $another_manila_alias = preg_match('/DWRX 93.1 Manila;/', $contract['station']);
            $cebu = preg_match('/DYBT Cebu;/', $contract['station']);
            $another_cebu_alias = preg_match('/DYBT 105.9 Cebu;/', $contract['station']);
            $davao = preg_match('/DXBT Davao;/', $contract['station']);
            $another_davao_alias = preg_match('/DXBT 99.5 Davao;/', $contract['station']);

            $stations = [];

            if($manila === 1 || $another_manila_alias === 1) {
                array_push($stations, '<div class="badge badge-primary text-center">Manila</div>');
            }

            if($cebu === 1 || $another_cebu_alias) {
                array_push($stations, '<div class="badge badge-warning text-center">Cebu</div>');
            }

            if($davao === 1 || $another_davao_alias) {
                array_push($stations, '<div class="badge badge-dark text-center">Davao</div>');
            }

            $contract['station'] = $stations;

            if ($contract->is_printed === 1) {
                $contract->print_status = "<div class='badge badge-success text-center'>Printed</div>";
            } else if ($contract->is_printed === 0) {
                $contract->print_status = "<div class='badge badge-danger text-center'>Pending</div>";
            }

            if($contract->advertiser_id === 0) {
                $contract->advertiser_name = '<div class="badge badge-danger text-center">Undefined</div>';
            } else {
                $contract->advertiser_name = $contract->Advertiser->advertiser_name;
            }

            if($contract->agency_id === 0) {
                $contract->agency_name = '<div class="badge badge-danger text-center">Undefined</div>';
            } else {
                $contract->agency_name = $contract->Agency->agency_name;
            }

            $contract->short_contract_number = Str::limit($contract->contract_number, '20');

            $contract->short_bo_number = Str::limit($contract->bo_number, '15');

            $contract->employee_name = $contract->Employee->first_name[0] . $contract->Employee->middle_name[0] . $contract->Employee->last_name[0];

            if ($contract->is_active === 1) {
                $contract->status = "<div class='badge badge-success text-center'>Active</div>";

                if($user_level === "1") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='".route('contracts.generate', $contract->id)."' tooltip title='Generate PDF' data-placement='bottom' class='btn btn-outline-dark'><i class='fas fa-download'></i></a>" .
                        "   <a href='#contract-status-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Reactivate' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-check'></i></a>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "</div>";
                } else if($user_level === "2") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "   <a href='#add-sales-breakdown-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Add Sales Breakdown' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-plus'></i></a>" .
                        "</div>";
                } else if($user_level === "3") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "</div>";
                } else {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='".route('contracts.generate', $contract->id)."' tooltip title='Generate PDF' data-placement='bottom' class='btn btn-outline-dark'><i class='fas fa-download'></i></a>" .
                        "   <a href='#add-sales-breakdown-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Add Sales Breakdown' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-plus'></i></a>" .
                        "   <a href='#contract-status-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Reactivate' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-check'></i></a>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "   <a href='#delete-contract-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Remove Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                        "</div>";
                }

            } else if ($contract->is_active === 0) {
                $contract->status = "<div class='badge badge-danger text-center'>Inactive</div>";

                if($user_level === "1") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='".route('contracts.generate', $contract->id)."' tooltip title='Generate PDF' data-placement='bottom' class='btn btn-outline-dark'><i class='fas fa-download'></i></a>" .
                        "   <a href='#add-sales-breakdown-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Add Sales Breakdown' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-plus'></i></a>" .
                        "   <a href='#contract-status-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Reactivate' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-check'></i></a>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "</div>";
                } else if($user_level === "2") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "</div>";
                } else if($user_level === "3") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "</div>";
                } else {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='".route('contracts.generate', $contract->id)."' tooltip title='Generate PDF' data-placement='bottom' class='btn btn-outline-dark'><i class='fas fa-download'></i></a>" .
                        "   <a href='#add-sales-breakdown-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Add Sales Breakdown' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-plus'></i></a>" .
                        "   <a href='#contract-status-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Reactivate' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-check'></i></a>" .
                        "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "   <a href='#delete-contract-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Remove Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                        "</div>";
                }
            }
        }

        if($request->ajax()) {
            $switchTo = $request['switch'];

            if($switchTo == "parent") {
                return view('webpages.contract.bo.parent.active');
            }

            if($switchTo === "inactive_parent") {
                return view('webpages.contract.bo.parent.inactive');
            }

            if($switchTo == "child_bo") {
                return view('webpages.contract.bo.child.active');
            }

            if($switchTo === "inactive_child_bo") {
                return view('webpages.contract.bo.child.inactive');
            }

            if($switchTo == "inactive") {
                return view('webpages.contract.inactive');
            }

            if($request->has('navigation')) {
                return view('webpages.contracts');
            }

            return $contracts;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }

    public function create() {
        $parents = Contract::where('bo_type', '=', 'normal')->orderBy('bo_number')->get()->pluck('bo_number');

        $advertisers = Advertiser::where('is_active', 1)
            ->orderBy('advertiser_name')
            ->get();
        $agencies = Agency::where('is_active', 1)
            ->orderBy('agency_name')
            ->get();

        return view('webpages.contract.create', compact('agencies', 'advertisers', 'parents'));
    }

    public function show(Request $request) {
        $user_level = Auth::user()->Job->level;

        $contract = Contract::with('Employee')->findOrFail($request['id']);

        $executives = Employee::where('job_id', '=', 2)->where('is_active', '=', 1)->get();

        $parents = Contract::where('bo_number', '!=', $contract['bo_number'])->where('bo_type', '=', 'normal')->orderBy('bo_number')->get()->pluck('bo_number');

        $agencies = Agency::where('is_active', 1)
            ->where('agency_code', '!=', $contract['agency_code'])
            ->get();
        $advertisers = Advertiser::where('is_active', 1)
            ->where('advertiser_code', '!=', $contract['advertiser_code'])
            ->get();

        // getting the radio stations by breaking down the data from the string
        $manila = preg_match('/DWRX Manila;/', $contract['station']);
        $another_manila_alias = preg_match('/DWRX 93.1 Manila;/', $contract['station']);
        $cebu = preg_match('/DYBT Cebu;/', $contract['station']);
        $another_cebu_alias = preg_match('/DYBT 105.9 Cebu;/', $contract['station']);
        $davao = preg_match('/DXBT Davao;/', $contract['station']);
        $another_davao_alias = preg_match('/DXBT 99.5 Davao;/', $contract['station']);

        $stations = [];

        if($manila === 1 || $another_manila_alias === 1) {
            array_push($stations, 'manila');
        }

        if($cebu === 1 || $another_cebu_alias) {
            array_push($stations, 'cebu');
        }

        if($davao === 1 || $another_davao_alias) {
            array_push($stations, 'davao');
        }

        $contract['station'] = $stations;

        if($request->ajax()) {
            if($request['modal'] === true || $request['modal'] === 'true') {
                return response()->json(['contract' => $contract]);
            }
        }

        if($user_level === "1") {
            return view('webpages.contract.traffic_edit', compact('contract', 'executives', 'agencies', 'advertisers', 'parents'));
        }

        if($user_level === "3") {
            return view('webpages.contract.view', compact('contract', 'agencies', 'advertisers', 'parents'));
        }

        return view('webpages.contract.edit', compact('contract', 'agencies', 'advertisers', 'parents'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'station' => ['required', 'array'],
            'agency_id' => 'required',
            'advertiser_id' => 'required',
            'product' => 'required',
            'bo_type' => 'required',
            'bo_number' => 'required',
            'commencement' => 'required',
            'end_of_broadcast' => 'required',
            'detail' => 'required',
            'package_cost_salesdc' => 'required',
            'manila_cash' => 'required',
            'cebu_cash' => 'required',
            'davao_cash' => 'required',
            'total_cash' => 'required',
            'manila_ex' => 'required',
            'cebu_ex' => 'required',
            'davao_ex' => 'required',
            'total_ex' => 'required',
            'total_amount' => 'required',
            'prod_cost_salesdc' => 'required',
            'manila_prod' => 'required',
            'cebu_prod' => 'required',
            'davao_prod' => 'required',
            'total_prod' => 'required',
        ]);

        if($request['bo_type'] == "normal") {
            $request['parent_bo'] = "none";
        }

        $employee_id = Auth::user()->id;
        $firstName = Auth::user()->first_name;
        $middleName = Auth::user()->middle_name;
        $lastName = Auth::user()->last_name;

        if($validator->passes()) {
            // creation of contract number
            $contract_number = date('Ymd') . '-' . $firstName[0] . $middleName[0] . $lastName[0] . '-' . mt_rand(100000, 999999);

            // storing the stations array as a string
            $stations = implode($request['station']);

            $request['station'] = $stations;

            $request['contract_number'] = $contract_number;
            $request['ae'] = Auth::user()->id;

            $contract = new Contract($request->all());

            $contract->save();

            $new_contract = Contract::latest()->get()->first();

            $logs = new AccountExecutiveLogs([
                'contract_id' => $new_contract['id'],
                'action' => 'Added a new contract with a contract number of ' . $new_contract['contract_number'] . ' and a Gross Amount of ' . $new_contract['gross_amount'],
                'bo_number' => $request['bo_number'],
                'employee_id' => $employee_id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'A contract has been successfully added!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()],400);
    }

    public function update($id, Request $request) {
        $contract = Contract::findOrFail($id);

        $agencies = Agency::where('is_active', 1)
            ->where('agency_code', '!=', $contract['agency_code'])
            ->get();

        $advertisers = Advertiser::where('is_active', 1)
            ->where('advertiser_code', '!=', $contract['advertiser_code'])
            ->get();

        if($request->ajax()) {
            if($request['activate']) {
                $contract->is_active = $request['status'];

                if($contract->is_active === 1) {
                    return response()->json(['status' => 'success', 'message' => 'A contract has been activated!']);
                }

                return response()->json(['status' => 'success', 'message' => 'A contract has been deactivated!']);
            }
        }

        $request['station'] = implode(" ", $request['station']);

        $revision = ContractRevision::where('contract_id', '=', $id);

        if($revision->count() == 1) {
            $revision->get()->first();

            $revision->increment('version');

            $revision->update([
                'contract_id' => $contract['id'],
                'contract_number' => $contract['contract_number'],
                'station' => $contract['station'],
                'agency_id' => $contract['agency_id'],
                'advertiser_id' => $contract['advertiser_id'],
                'product' => $contract['product'],
                'bo_type' => $contract['bo_type'],
                'parent_bo' => $contract['parent_bo'],
                'bo_number' => $contract['bo_number'],
                'ce_number' => $contract['ce_number'],
                'bo_date' => $contract['bo_date'],
                'commencement' => $contract['commencement'],
                'end_of_broadcast' => $contract['end_of_broadcast'],
                'detail' => $contract['detail'],
                'package_cost' => $contract['package_cost'],
                'package_cost_vat' => $contract['package_cost_vat'],
                'package_cost_salesdc' => $contract['package_cost_salesdc'],
                'manila_cash' => $contract['manila_cash'],
                'cebu_cash' => $contract['cebu_cash'],
                'davao_cash' => $contract['davao_cash'],
                'total_cash' => $contract['total_cash'],
                'manila_ex' => $contract['manila_ex'],
                'cebu_ex' => $contract['cebu_ex'],
                'davao_ex' => $contract['davao_ex'],
                'total_ex' => $contract['total_ex'],
                'total_amount' => $contract['total_amount'],
                'prod_cost' => $contract['prod_cost'],
                'prod_cost_vat' => $contract['prod_cost_vat'],
                'prod_cost_salesdc' => $contract['prod_cost_salesdc'],
                'manila_prod' => $contract['manila_prod'],
                'cebu_prod' => $contract['cebu_prod'],
                'davao_prod' => $contract['davao_prod'],
                'total_prod' => $contract['total_prod'],
                'ae' => $contract['ae'],
                'is_printed' => $contract['is_printed'],
                'is_active' => $contract['is_active'],
            ]);
        } else {
            $contract_revision = new ContractRevision($contract->toArray());

            $contract_revision['contract_id'] = $contract->id;
            $contract_revision['version'] = 1;

            $contract_revision->save();
        }

        $contract->update($request->all());

        $employee_id = Auth::user()->id;

        $logs = new AccountExecutiveLogs([
            'contract_id' => $contract->id,
            'action' => 'Updated a contract from '. $contract->Employee->first_name . ' ' . $contract->Employee->last_name .' with a contract number of ' . $contract['contract_number'],
            'bo_number' => $contract->bo_number,
            'employee_id' => $employee_id
        ]);

        $logs->save();

        $parents = Contract::where('bo_number', '!=', $contract['bo_number'])->where('bo_type', '=', 'normal')->orderBy('bo_number')->get()->pluck('bo_number');

        // getting the radio stations by breaking down the data from the string
        $manila = preg_match('/DWRX Manila;/', $contract['station']);
        $another_manila_alias = preg_match('/DWRX 93.1 Manila;/', $contract['station']);
        $cebu = preg_match('/DYBT Cebu;/', $contract['station']);
        $another_cebu_alias = preg_match('/DYBT 105.9 Cebu;/', $contract['station']);
        $davao = preg_match('/DXBT Davao;/', $contract['station']);
        $another_davao_alias = preg_match('/DXBT 99.5 Davao;/', $contract['station']);

        $stations = [];

        if($manila === 1 || $another_manila_alias === 1) {
            array_push($stations, 'manila');
        }

        if($cebu === 1 || $another_cebu_alias) {
            array_push($stations, 'cebu');
        }

        if($davao === 1 || $another_davao_alias) {
            array_push($stations, 'davao');
        }

        $contract['station'] = $stations;

        session()->flash('status', ['message' => 'A contract has been successfully updated!']);
        return view('webpages.contract.view', compact('contract', 'agencies', 'advertisers', 'parents'));
    }

    public function delete($id) {
        $contract = Contract::findOrFail($id);

        $employee_id = Auth::user()->id;

        $logs = new AccountExecutiveLogs([
            'contract_id' => $contract->id,
            'action' => 'Tried to delete '. $contract['contract_number'] . ' with a bo number of '. $contract['bo_number'] .' but we don\'t delete data here.',
            'bo_number' => $contract->bo_number,
            'employee_id' => $employee_id
        ]);

        $logs->save();

        return response()->json(['status' => 'success', 'message' => 'A contract has been successfully deleted!']);
    }

    public function generatePDF($id) {
        $contract = Contract::with('Agency', 'Advertiser', 'Employee')->findOrFail($id);

        view()->share('contract', $contract);
        $pdf = PDF::loadView('layouts.print', $contract);

        $contract['is_printed'] = 1;

        $contract->save();

        return $pdf->download(date('Y-m-d') . '-' . $contract['contract_number'] . ".pdf");
    }
}
