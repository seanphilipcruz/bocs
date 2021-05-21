<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Agency;
use App\Contract;
use App\Employee;
use App\Sales;
use App\SalesLogs;
use App\SalesRevision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class SalesController extends Controller
{
    public function index(Request $request) {
        $executive = Auth::user()->id;
        $user_level = Auth::user()->Job->level;

        if($user_level === "2") {
            $contracts = Contract::has('Sales')
                ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                ->where('ae', '=', $executive)
                ->where('is_active', '=', '1')
                ->orderBy('created_at')
                ->get();

            if($request['inactive']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'normal')
                    ->orWhere('bo_type', '=', 'parent')
                    ->where('is_active', '=', '0')
                    ->where('ae', '=', $executive)
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['parent']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('ae', '=', $executive)
                    ->where('is_active', '=', '1')
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_parent']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('ae', '=', $executive)
                    ->where('is_active', '=', '0')
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['child_bo']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '1')
                    ->where('ae', '=', $executive)
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_child_bo']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '0')
                    ->where('ae', '=', $executive)
                    ->orderBy('created_at')
                    ->get();
            }
        } else {
            $contracts = Contract::has('Sales')
                ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                ->where('bo_type', '=', 'normal')
                ->where('is_active', '=', '1')
                ->get();

            if($request['inactive']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'normal')
                    ->orWhere('bo_type', '=', 'parent')
                    ->where('is_active', '=', '0')
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['parent']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('is_active', '=', '1')
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_parent']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'parent')
                    ->where('is_active', '=', '0')
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['child_bo']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '1')
                    ->orderBy('created_at')
                    ->get();
            }

            if($request['inactive_child_bo']) {
                $contracts = Contract::has('Sales')
                    ->with('Sales', 'Agency', 'Advertiser', 'Employee')
                    ->where('bo_type', '=', 'child')
                    ->where('is_active', '=', '0')
                    ->orderBy('created_at')
                    ->get();
            }
        }

        foreach ($contracts as $contract) {

            // catching the advertiser / agency that has no value
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

            $contract->executive = $contract->Employee->first_name[0] . $contract->Employee->middle_name[0] . $contract->Employee->last_name[0];

            foreach ($contract->Sales as $sale) {
                // getting the breakdown of the contracts
                $contract->breakdown_amount = array_sum($sale->where('contract_id', $contract->id)->pluck('gross_amount')->toArray());
                $contract->breakdown_prod = array_sum($sale->where('contract_id', $contract->id)->where('type', '=', 'totalprod')->pluck('gross_amount')->toArray());

                // displaying the total amount in the tables
                if($contract->total_amount == $contract->breakdown_amount) {
                    $contract->total = "<div class='badge badge-success'>".number_format($contract->total_amount,2)."</div>";
                    $contract->total_breakdown = "<div class='badge badge-success'>".number_format(array_sum($sale->where('contract_id', $contract->id)->pluck('gross_amount')->toArray()),2)."</div>";
                } else {
                    $contract->total = "<div class='badge badge-info'>".number_format($contract->total_amount,2)."</div>";
                    $contract->total_breakdown = "<div class='badge badge-danger'>".number_format(array_sum($sale->where('contract_id', $contract->id)->pluck('gross_amount')->toArray()),2)."</div>";
                }

                // displaying the total prod
                if($contract->total_prod == $contract->breakdown_prod) {
                    $contract->prod = "<div class='badge badge-success'>".number_format($contract->total_prod,2)."</div>";
                    $contract->total_prod_breakdown = "<div class='badge badge-success'>".number_format(array_sum($sale->where('contract_id', $contract->id)->where('type', '=', 'totalprod')->pluck('gross_amount')->toArray()),2)."</div>";
                } else {
                    $contract->prod = "<div class='badge badge-primary'>".number_format($contract->total_prod,2)."</div>";
                    $contract->total_prod_breakdown = "<div class='badge badge-danger'>".number_format(array_sum($sale->where('contract_id', $contract->id)->where('type', '=', 'totalprod')->pluck('gross_amount')->toArray()),2)."</div>";
                }

                $contract->short_bo_number = Str::limit($contract->bo_number, '20');

                $contract->short_parent_bo = Str::limit($contract->parent_bo, '15');

                if($sale->type == 'airtime' || $sale->type == 'totalamount') {
                    $sale->type = 'Air Time';
                }

                if($sale->type == 'top10') {
                    $sale->type = 'Top 10 Sponsorship';
                }

                if($sale->type == 'live') {
                    $sale->type = 'Live Guesting/Interview';
                }

                if($sale->type == 'DJDisc') {
                    $sale->type = 'DJ Discussion';
                }

                if($sale->type == 'Spots' || $sale->type == 'spots') {
                    $sale->type = 'Spots';
                }

                if($sale->type == 'totalprod') {
                    $sale->type = 'Production';
                }

                if($user_level === "2") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#update-sale-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='View Sale' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "   <a href='#update-invoice-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='Invoice Number' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-file-alt'></i></a>" .
                        "</div>";
                } else if($user_level === "3") {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#update-invoice-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='Invoice Number' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-file-alt'></i></a>" .
                        "</div>";
                }

                if($request['contract_sales']) {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#' data-action='breakdown' data-link='".route('sales.show.breakdowns')."' data-id='".$sale->bo_number."' modal='true' tooltip title='View Breakdowns' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-list-ul'></i></a>" .
                        "   <a href='#update-invoice-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='Invoice Number' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-file-alt'></i></a>" .
                        "</div>";
                } else {
                    $contract->options = "" .
                        "<div class='btn-group'>" .
                        "   <a href='#update-sale-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='View Sale' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                        "   <a href='#update-invoice-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='Invoice Number' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-file-alt'></i></a>" .
                        "</div>";
                }
            }
        }

        if($request->ajax()) {
            $switchTo = $request['switch'];

            if($switchTo == "parent") {
                return view('webpages.sales.contracts.bo.parent.active');
            }

            if($switchTo === "inactive_parent") {
                return view('webpages.sales.contracts.bo.parent.inactive');
            }

            if($switchTo == "inactive") {
                return view('webpages.sales.contracts.inactive');
            }

            if($switchTo == "child_bo") {
                return view('webpages.sales.contracts.bo.child.active');
            }

            if($switchTo === "inactive_child_bo") {
                return view('webpages.sales.contracts.bo.child.inactive');
            }

            if($request['navigation'] == "breakdowns") {
                return view('webpages.breakdowns');
            }

            if($request['navigation']) {
                return view('webpages.sales.contracts.index');
            }

            return $contracts;
        }

        return response()->json(['status' => 'success', 'message' => 'Webpage you were looking for weren\'t found'], 400);
    }

    public function create() {
        return view('webpages.sales.create');
    }

    public function show(Request $request) {
        $sale = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->findOrFail($request['id']);

        if($request->ajax()) {
            if($request['modal']) {
                return response()->json(['sale' => $sale]);
            }
        }

        return view('webpages.sales.view', compact('sale'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'contract_id' => 'required',
            'bo_number' => 'required',
            'bo_type' => 'required',
            'station' => 'required',
            'month' => 'required',
            'year' => 'required',
            'type' => 'required',
            'amount_type' => 'required',
            'amount' => 'required',
            'gross_amount' => 'required',
            'agency_id' => 'required',
            'advertiser_id' => 'required',
            'ae' => 'required'
        ]);

        if($validator->passes()) {
            $sales = new Sales();

            $sales->fill($request->all());

            $sales->save();

            $new_sales = Sales::latest()->get()->first();

            $logs = new SalesLogs([
                'sales_id' => $new_sales->id,
                'action' => 'Sales breakdown added to '. $request['bo_number'] .' with a gross amount of ' . $new_sales['gross_amount'],
                'bo_number' => $new_sales['bo_number'],
                'type' => $new_sales['type'],
                'amount' => $new_sales['amount'],
                'gross_amount' => $new_sales['gross_amount'],
                'employee_id' => Auth::user()->id
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'A new sales breakdown has been added!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()], 400);
    }

    public function update($id, Request $request) {
        $sale = Sales::with('Contract')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required',
            'type' => 'required',
            'amount_type' => 'required',
            'amount' => 'required',
            'gross_amount' => 'required'
        ]);

        if($validator->passes()) {
            $employee_id = Auth::user()->id;

            if($request['invoice_no']) {
                $sale->update($request->all());

                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Invoice number added to the sales breakdown with a bo_number of ' . $sale['bo_number'] . ' and a contract number of ' . $sale->Contract->contract_number,
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();

                return response()->json(['status' => 'success', 'message' => 'Invoice number has been added!']);
            }

            // verify if the sales_id is revised
            $revision = SalesRevision::where('sales_id', $sale->id);

            if($request['invoice_no'] != $sale['invoice_no']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the invoice_no of the sales breakdown with a bo_number of ' . $sale['bo_number'] . ' and a contract number of ' . $sale->Contract->contract_number . ' from ' . $sale['invoice_no'] . ' to ' . $request['invoice_no'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();
            }

            if($request['month'] != $sale['month']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the month of the sales breakdown with a bo_number of ' . $sale['bo_number'] . ' and a contract number of ' . $sale->Contract->contract_number . ' from ' . $sale['month'] . ' to ' . $request['month'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();
            }

            if($request['year'] != $sale['year']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the year of the sales breakdown with a bo_number of ' . $sale['bo_number'] . ' and a contract number of ' . $sale->Contract->contract_number . ' from ' . $sale['year'] . ' to ' . $request['year'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();
            }

            if($request['type'] != $sale['type']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the type of the sales breakdown from ' . $sale['type'] . ' to ' . $request['type'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();
            }

            if($request['amount_type'] != $sale['amount_type']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the type of amount of the sales breakdown from ' . $sale['amount_type'] . ' to ' . $request['amount_type'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();
            }

            if($request['amount'] != $sale['amount']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the amount of the sales breakdown with a bo_number of ' . $sale['bo_number'] . ' and a contract number of ' . $sale->Contract->contract_number . ' and the amount from ' . $sale['amount'] . ' to ' . $request['amount'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $request['amount'],
                    'gross_amount' => $sale['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();

                if($revision->count() == 1) {
                    $revision->get()->first();

                    $revision->increment('version');

                    $revision->update([
                        'sales_id' => $sale['id'],
                        'contract_id' => $sale['contract_id'],
                        'bo_number' => $sale['bo_number'],
                        'bo_type' => $sale['bo_type'],
                        'station' => $sale['station'],
                        'month' => $sale['month'],
                        'year' => $sale['year'],
                        'type' => $sale['type'],
                        'amount_type' => $sale['amount_type'],
                        'amount' => $sale['amount'],
                        'gross_amount' => $sale['gross_amount'],
                        'agency_id' => $sale['agency_id'],
                        'advertiser_id' => $sale['advertiser_id'],
                        'ae' => $sale['ae'],
                        'invoice_no' => $sale['invoice_no'],
                    ]);
                } else {
                    $sales_revision = new SalesRevision([
                        'sales_id' => $sale['id'],
                        'contract_id' => $sale['contract_id'],
                        'bo_number' => $sale['bo_number'],
                        'bo_type' => $sale['bo_type'],
                        'station' => $sale['station'],
                        'month' => $sale['month'],
                        'year' => $sale['year'],
                        'type' => $sale['type'],
                        'amount_type' => $sale['amount_type'],
                        'amount' => $sale['amount'],
                        'gross_amount' => $sale['gross_amount'],
                        'agency_id' => $sale['agency_id'],
                        'advertiser_id' => $sale['advertiser_id'],
                        'ae' => $sale['ae'],
                        'invoice_no' => $sale['invoice_no'],
                        'version' => 1,
                    ]);

                    $sales_revision->save();
                }
            }

            if($request['gross_amount'] != $sale['gross_amount']) {
                $logs = new SalesLogs([
                    'sales_id' => $sale->id,
                    'action' => 'Changed the gross amount of the sales breakdown with a bo_number of ' . $sale['bo_number'] . ' and a contract number of ' . $sale->Contract->contract_number  . ' and the amount from ' . $sale['gross_amount'] . ' to ' . $request['gross_amount'],
                    'bo_number' => $sale['bo_number'],
                    'type' => $sale['type'],
                    'amount' => $sale['amount'],
                    'gross_amount' => $request['gross_amount'],
                    'employee_id' => $employee_id
                ]);

                $logs->save();

                if($revision->count() == 1) {
                    $revision->get()->first();

                    $revision->increment('version');

                    $revision->update([
                        'sales_id' => $sale['id'],
                        'contract_id' => $sale['contract_id'],
                        'bo_number' => $sale['bo_number'],
                        'station' => $sale['station'],
                        'bo_type' => $sale['bo_type'],
                        'month' => $sale['month'],
                        'year' => $sale['year'],
                        'type' => $sale['type'],
                        'amount_type' => $sale['amount_type'],
                        'amount' => $sale['amount'],
                        'gross_amount' => $sale['gross_amount'],
                        'agency_id' => $sale['agency_id'],
                        'advertiser_id' => $sale['advertiser_id'],
                        'ae' => $sale['ae'],
                        'invoice_no' => $sale['invoice_no'],
                    ]);
                } else {
                    $sales_revision = new SalesRevision([
                        'sales_id' => $sale['id'],
                        'contract_id' => $sale['contract_id'],
                        'bo_number' => $sale['bo_number'],
                        'station' => $sale['station'],
                        'bo_type' => $sale['bo_type'],
                        'month' => $sale['month'],
                        'year' => $sale['year'],
                        'type' => $sale['type'],
                        'amount_type' => $sale['amount_type'],
                        'amount' => $sale['amount'],
                        'gross_amount' => $sale['gross_amount'],
                        'agency_id' => $sale['agency_id'],
                        'advertiser_id' => $sale['advertiser_id'],
                        'ae' => $sale['ae'],
                        'invoice_no' => $sale['invoice_no'],
                        'version' => 1,
                    ]);

                    $sales_revision->save();
                }
            }

            $sale->update($request->all());

            return response()->json(['status' => 'success', 'message' => 'Sales breakdown has been updated!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()], 400);
    }

    public function delete($id) {
        $sale = Sales::with('Contract')->findOrFail($id);

        $user_level = Auth::user()->Employee->Job->level;

        if($user_level === '0' || $user_level === '1') {
            $sale->delete();

            return response()->json(['status' => 'success', 'message' => 'A sale has been deleted!']);
        }

        return response()->json(['status' => 'error', 'message' => 'You don\'t have the administrative rights!'], 400);
    }

    public function breakdowns(Request $request) {
        $user_level = Auth::user()->Job->level;

        $sales_breakdown = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->where('bo_number', $request['bo_number'])->get();

        foreach ($sales_breakdown as $breakdowns) {
            $breakdowns->date = $breakdowns['year'] . '-' . $breakdowns['month'];

            $breakdowns->amount = number_format($breakdowns->amount, 2);

            $breakdowns->gross_amount = number_format($breakdowns->gross_amount, 2);

            if($user_level === "0") {
                $breakdowns->options = "" .
                    "<div class='btn-group'>" .
                    "   <a href='#update-sale-modal' data-link='".route('sales.show')."' data-action='open' data-id='".$breakdowns->id."' modal='true' tooltip title='Update Sales Breakdown' data-placement='Bottom' data-toggle='modal' class='btn btn-outline-dark'>" .
                    "       <i class='fas fa-edit'></i>" .
                    "   </a>" .
                    "</div>";
            } else if($user_level === "1") {
                $breakdowns->options = "" .
                    "<div class='btn-group'>" .
                    "   <a href='#update-sale-modal' data-link='".route('sales.show')."' data-action='open' data-id='".$breakdowns->id."' modal='true' tooltip title='Update Sales Breakdown' data-placement='Bottom' data-toggle='modal' class='btn btn-outline-dark'>" .
                    "       <i class='fas fa-edit'></i>" .
                    "   </a>" .
                    "</div>";
            } else if($user_level === "2") {
                $breakdowns->options = "";
            } else if($user_level === "3") {
                $breakdowns->options = "";
            } else {
                $breakdowns->options = "" .
                    "<div class='btn-group'>" .
                    "   <a href='#update-sale-modal' data-link='".route('sales.show')."' data-action='open' data-id='".$breakdowns->id."' modal='true' tooltip title='Update Sales Breakdown' data-placement='Bottom' data-toggle='modal' class='btn btn-outline-dark'>" .
                    "       <i class='fas fa-edit'></i>" .
                    "   </a>" .
                    "</div>";
            }
        }

        $bo_number = $request['bo_number'];

        if($request->ajax()) {
            if($request['view'] === 'breakdown') {
                return view('webpages.sales.breakdown', compact('bo_number'));
            }

            return $sales_breakdown;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for weren\'t found'], 400);
    }

    public function report(Request $request) {
        // by default sales are displayed monthly
        // other values for date() can be found in https://www.w3schools.com/php/func_date_date.asp
        $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
            ->where('month', date('m'))
            ->where('year', date('Y'))
            ->get();

        $month = date('F');

        $query = $request['sort'];

        if($query) {
            if($query == 'all') {
                $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->get();
                $month = 'All Time';
            } else {
                // if query has an employee
                if($query['employee_id'] != "" || $query['employee_id'] != null) {
                    $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                        ->where('ae', '=', $query['employee_id'])
                        ->get();

                    $employee = Employee::findOrFail($query['employee_id']);

                    $month = $employee->first_name . ' ' . $employee->last_name . '\'s';
                }

                // if query has a station
                if($query['station'] != "" || $query['station'] != null) {
                    $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                        ->where('station', '=', $query['station'])
                        ->get();

                    $month = ucfirst($query['station']);
                }

                // if user wants to see the sales with a specific agency
                if($query['agency_id'] != "" || $query['agency_id'] != null) {
                    $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                        ->where('agency_id', '=', $query['agency_id'])
                        ->get();

                    $month = $query['agency_name'] . '\'s';
                }

                // if user wants to see the sales with a specific agency
                if($query['advertiser_id'] != "" || $query['advertiser_id'] != null) {
                    $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                        ->where('advertiser_id', '=', $query['advertiser_id'])
                        ->get();

                    $month = $query['advertiser_name'] . '\'s';
                }

                // yearly sales
                if($query['year'] != "" || $query['year'] != null) {
                    $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                        ->where('year', '=', $query['year'])
                        ->orderBy('month')
                        ->get();

                    $month = $query['year'];
                }

                // specified monthly sales
                if($query['month'] != "" || $query['month'] != null && $query['mo_year'] != "" || $query['mo_year'] != null) {
                    $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                        ->where('month', '=', $query['month'])
                        ->where('year', '=', $query['mo_year'])
                        ->get();

                    $date = \DateTime::createFromFormat('!m', $query['month']);

                    $month = $date->format('F') . ' ' . $query['mo_year'];
                }

                // quarterly sales
                if($query['quarter'] != "" || $query['quarter'] != null && $query['qr_year'] != "" || $query['qr_year'] == null) {
                    $quarter = $query['quarter'];

                    if ($quarter == 1) {
                        $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                            ->where('month', '=', '01')
                            ->where('year', $query['qr_year'])
                            ->orWhere('month', '=', '02')
                            ->where('year', $query['qr_year'])
                            ->orWhere('month', '=', '03')
                            ->where('year', $query['qr_year'])
                            ->get();
                        $month = 'First Quarter of '. $query['qr_year'];
                    }

                    if ($quarter == 2) {
                        $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                            ->where('month', '04')
                            ->where('year', '==', $query['qr_year'])
                            ->orWhere('month', '05')
                            ->where('year', '==', $query['qr_year'])
                            ->orWhere('month', '06')
                            ->where('year', '==', $query['qr_year'])
                            ->get();
                        $month = 'Second Quarter of '. $query['qr_year'];
                    }

                    if ($quarter == 3) {
                        $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                            ->where('month', '07')
                            ->where('year', '==', $query['qr_year'])
                            ->orWhere('month', '08')
                            ->where('year', '==', $query['qr_year'])
                            ->orWhere('month', '09')
                            ->where('year', '==', $query['qr_year'])
                            ->get();
                        $month = 'Third Quarter of '. $query['qr_year'];
                    }

                    if ($quarter == 4) {
                        $sales_report = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')
                            ->where('month', '10')
                            ->where('year', '==', $query['qr_year'])
                            ->orWhere('month', '11')
                            ->where('year', '==', $query['qr_year'])
                            ->orWhere('month', '12')
                            ->where('year', '==', $query['qr_year'])
                            ->get();

                        $month = 'Fourth Quarter of '. $query['qr_year'];
                    }
                }
            }
        }

        $advertisers = Advertiser::where('is_active', '=', '1')->get();

        $agencies = Agency::where('is_active', '=', '1')->get();

        $executives = DB::table('sales')
            ->join('employees', 'sales.ae', '=', 'employees.id')
            ->select('employees.id', 'employees.first_name', 'employees.last_name')
            ->groupBy('employees.id')
            ->orderBy('employees.first_name')
            ->get();

        $yearly_sales = DB::table('sales')->select('year')->orderBy('year')->groupBy('year')->pluck('year');

        $gross_sales = number_format(array_sum($sales_report->pluck('gross_amount')->toArray()), 2);

        foreach ($sales_report as $sales) {
            $sales->amount = number_format($sales->amount, 2);
            $sales->gross_amount = number_format($sales->gross_amount, 2);
        }

        if($request->ajax()) {
            if($request['switch'] == "monthly") {
                $sales_report = Sales::selectRaw('month, sum(gross_amount) as gross_sales, year, station')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->groupBy(['month', 'year', 'station'])
                    ->get();

                foreach ($sales_report as $sales) {
                    $sales->gross_sales = number_format($sales->gross_sales, 2);
                }

                $gross_sales = $sales_report->where('month', date('m'))->where('year', date('Y'))->pluck('gross_sales')->first();

                return view('webpages.sales_monthly', compact('sales_report', 'gross_sales'));
            }

            if($request['switch'] == "executive") {
                $sales_report = Sales::with('Employee')->selectRaw('month, year, sum(gross_amount) as gross_sales, ae')
                    ->orderBy('year', 'desc')
                    ->orderBy('month')
                    ->groupBy(['month', 'year', 'ae'])
                    ->get();

                foreach($sales_report as $sales) {
                    $sales->gross_sales = number_format($sales->gross_sales, 2);
                }

                $gross_sales = number_format(array_sum(Sales::all()->pluck('gross_amount')->toArray()), 2);

                return view('webpages.sales_executive', compact('sales_report', 'gross_sales'));
            }

            if($request['sort']) {
                return view('webpages.sales_report', compact('sales_report','gross_sales', 'month', 'advertisers', 'agencies', 'executives', 'yearly_sales'));
            }

            if($request['navigation']) {
                return view('webpages.sales_report', compact('sales_report','gross_sales', 'month', 'advertisers', 'agencies', 'executives', 'yearly_sales'));
            }
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for weren\'t found'], 400);
    }
}
