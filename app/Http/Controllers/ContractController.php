<?php

namespace App\Http\Controllers;

use App\AccountExecutiveLogs;
use App\Advertiser;
use App\Agency;
use App\Contract;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;

class ContractController extends Controller
{
    public function index(Request $request) {
        $contracts = Contract::with('Agency', 'Advertiser', 'Employee')->where('bo_type', '=', 'normal')->where('is_active', '=', '1')->orderBy('created_at')->get();

        if($request['child_bo']) {
            $contracts = Contract::with('Agency', 'Advertiser', 'Employee')->where('bo_type', '=', 'child_bo')->where('is_active', '=', '1')->orderBy('created_at')->get();
        }

        if($request['inactive_child_bo']) {
            $contracts = Contract::with('Agency', 'Advertiser', 'Employee')->where('bo_type', '=', 'child_bo')->where('is_active', '=', '0')->orderBy('created_at')->get();
        }

        if($request['inactive']) {
            $contracts = Contract::with('Agency', 'Advertiser', 'Employee')->where('bo_type', '=', 'normal')->where('is_active', '=', '0')->orderBy('created_at')->get();
        }

        foreach ($contracts as $contract) {

            if ($contract->is_printed === 1) {
                $contract->print_status = "<div class='text-success text-center'>Printed</div>";
            } else if ($contract->is_printed === 0) {
                $contract->print_status = "<div class='text-danger text-center'>Pending</div>";
            }

            if($contract->advertiser_id === 0) {
                $contract->advertiser_name = '<div class="text-danger">Undefined</div>';
            } else {
                $contract->advertiser_name = $contract->Advertiser->advertiser_name;
            }

            if($contract->agency_id === 0) {
                $contract->agency_name = '<div class="text-danger">Undefined</div>';
            } else {
                $contract->agency_name = $contract->Agency->agency_name;
            }

            if ($contract->is_active === 1) {
                $contract->status = "<div class='text-success text-center'>Active</div>";
                $contract->options = "" .
                    "<div class='btn-group'>" .
                    "   <a href='".route('contracts.generate', $contract->id)."' tooltip title='Generate PDF' data-placement='bottom' class='btn btn-outline-dark'><i class='fas fa-download'></i></a>" .
                    "   <a href='#add-sales-breakdown-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Add Sales Breakdown' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-plus'></i></a>" .
                    "   <a href='#contract-status-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Deactivate' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-times'></i></a>" .
                    "   <a href='#' data-action='view' data-open='contract' data-link='".route('contracts.show')."' data-id='".$contract->id."' tooltip title='View Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                    "   <a href='#delete-contract-modal' data-action='open' data-link='".route('contracts.show')."' data-id='".$contract->id."' modal='true' tooltip title='Remove Contract' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-trash'></i></a>" .
                    "</div>";

            } else if ($contract->is_active === 0) {
                $contract->status = "<div class='text-danger text-center'>Inactive</div>";
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

        if($request->ajax()) {
            $switchTo = $request['switch'];

            if($switchTo == "inactive") {
                return view('webpages.contract.inactive');
            }

            if($switchTo == "child_bo") {
                return view('webpages.contract.bo.child.active');
            }

            if($switchTo === "inactive_child_bo") {
                return view('webpages.contract.bo.child.inactive');
            }

            if($request->has('navigation')) {
                return view('webpages.contracts');
            }

            return $contracts;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }

    public function create() {
        $advertisers = Advertiser::where('is_active', 1)
            ->orderBy('advertiser_name')
            ->get();
        $agencies = Agency::where('is_active', 1)
            ->orderBy('agency_name')
            ->get();

        return view('webpages.contract.create', compact('agencies', 'advertisers'));
    }

    public function show(Request $request) {
        $contract = Contract::with('Employee')->findOrFail($request['id']);
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

        return view('webpages.contract.view', compact('contract', 'agencies', 'advertisers'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'station' => ['required', 'array'],
            'agency_id' => 'required',
            'advertiser_id' => 'required',
            'product' => 'required',
            'bo_type' => 'required',
            'parent_bo' => 'required',
            'bo_number' => 'required',
            'ce_number' => 'required',
            'commencement' => 'required',
            'end_of_broadcast' => 'required',
            'detail' => 'required',
            'package_cost' => 'required',
            'package_cost_vat' => 'required',
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
            'prod_cost' => 'required',
            'prod_cost_vat' => 'required',
            'prod_cost_salesdc' => 'required',
            'manila_prod' => 'required',
            'cebu_prod' => 'required',
            'davao_prod' => 'required',
            'total_prod' => 'required',
        ]);

        $employee_id = Auth::user()->id;
        $firstName = Auth::user()->first_name;
        $middleName = Auth::user()->middle_name;
        $lastName = Auth::user()->last_name;

        if($validator->passes()) {
            // creation of contract number
            $contract_number = date('Y-m-d') . '-' . $firstName[0] . $middleName[0] . $lastName[0];

            $request['contract_number'] = $contract_number;
            $request['ae'] = Auth::user()->id;

            Contract::create($request->all());

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

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
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

        $contract->update($request->all());

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

        $employee_id = Auth::user()->id;

        $logs = new AccountExecutiveLogs([
            'contract_id' => $contract->id,
            'action' => 'Updated a contract from '. $contract->Employee->first_name . ' ' . $contract->Employee->last_name .' with a contract number of ' . $contract['contract_number'],
            'bo_number' => $contract->bo_number,
            'employee_id' => $employee_id
        ]);

        $logs->save();

        session()->flash('status', ['message' => 'A contract has been successfully updated!']);
        return view('webpages.contract.view', compact('contract', 'agencies', 'advertisers'));
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
