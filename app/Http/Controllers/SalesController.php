<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Agency;
use App\Employee;
use App\Sales;
use App\SalesLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;

class SalesController extends Controller
{
    public function index(Request $request) {
        $sales = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->get();

        foreach ($sales as $sale) {
            $sale->date = $sale['year'] . " " . $sale['month'];

            $sale->bo_number = Str::limit($sale->bo_number, '25', '...');

            $sale->executive = $sale->Contract->Employee->first_name[0] . $sale->Contract->Employee->middle_name[0] . $sale->Contract->Employee->last_name[0];

            if($sale['type'] === 'airtime' || $sale['type'] === 'totalamount') {
                $sale['type'] = 'Air Time';
            }

            if($sale['type'] === 'top10') {
                $sale['type'] = 'Top 10 Sponsorship';
            }

            if($sale['type'] === 'live') {
                $sale['type'] = 'Live Guesting/Interview';
            }

            if($sale['type'] === 'DJDisc') {
                $sale['type'] = 'DJ Discussion';
            }

            if($sale['type'] === 'Spots' || $sale['type'] === 'spots') {
                $sale['type'] = 'Spots';
            }

            if($sale['type'] === 'totalprod') {
                $sale['type'] = 'Production';
            }

            $sale->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#' data-action='breakdown' data-link='".route('sales.show.breakdowns')."' data-id='".$sale->bo_number."' modal='true' tooltip title='View Breakdowns' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-list-ul'></i></a>" .
                "   <a href='#update-invoice-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='Invoice Number' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-file-alt'></i></a>" .
                "   <a href='#update-sale-modal' data-action='open' data-link='".route('sales.show')."' data-id='".$sale->id."' modal='true' tooltip title='View Sale' data-placement='bottom' data-toggle='modal' class='btn btn-outline-dark'><i class='fas fa-edit'></i></a>" .
                "</div>";
        }

        if($request->ajax()) {
            if($request['navigation']) {
                return view('webpages.sales');
            }

            return $sales;
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
            'month' => 'required',
            'year' => 'required',
            'type' => 'required',
            'amount_type' => 'required',
            'amount' => 'required',
            'gross_amount' => 'required',
            'invoice_no' => 'required',
        ]);

        if($validator->passes()) {
            Sales::create($request->all());

            $new_sales = Sales::latest()->get()->first();

            $logs = new SalesLogs([
                'sales_id' => $new_sales->id,
                'action' => 'Sales breakdown added with a gross amount of ' . $new_sales['gross_amount'],
                'bo_number' => $new_sales['bo_number'],
                'type' => $new_sales['type'],
                'amount' => $new_sales['amount'],
                'gross_amount' => $new_sales['gross_amount']
            ]);

            $logs->save();

            return response()->json(['status' => 'success', 'message' => 'A new sales breakdown has been added!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
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
            }

            $sale->update($request->all());

            return response()->json(['status' => 'success', 'message' => 'Sales breakdown has been updated!']);
        }

        return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
    }

    public function delete($id) {
        $sale = Sales::with('Contract')->findOrFail($id);

        $user_level = Auth::user()->Employee->Job->level;

        if($user_level === '0' || $user_level === '1') {
            $sale->delete();

            return response()->json(['status' => 'success', 'message' => 'A sale has been deleted!']);
        }

        return response()->json(['status' => 'error', 'message' => 'You don\'t have the administrative rights!']);
    }

    public function breakdowns(Request $request) {
        $sales_breakdown = Sales::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->where('bo_number', $request['bo_number'])->get();

        foreach ($sales_breakdown as $breakdowns) {
            $breakdowns->date = $breakdowns['year'] . '-' . $breakdowns['month'];

            $breakdowns->amount = number_format($breakdowns->amount, 2);

            $breakdowns->gross_amount = number_format($breakdowns->gross_amount, 2);

            $breakdowns->options = "" .
                "<div class='btn-group'>" .
                "   <a href='#update-sale-modal' data-link='".route('sales.show')."' data-action='open' data-id='".$breakdowns->id."' modal='true' tooltip title='Update Sales Breakdown' data-placement='Bottom' data-toggle='modal' class='btn btn-outline-dark'>" .
                "       <i class='fas fa-edit'></i>" .
                "   </a>" .
                "</div>";
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

                $gross_sales = number_format(array_sum($sales_report->where('month', date('d'))->pluck('gross_amount')->toArray()), 2);

                return view('webpages.sales_monthly', compact('sales_report', 'gross_sales'));
            }

            if($request['sort']) {
                return view('webpages.sales_report', compact('sales_report','gross_sales', 'month', 'advertisers', 'month', 'agencies', 'executives', 'yearly_sales'));
            }

            if($request['navigation']) {
                return view('webpages.sales_report', compact('sales_report','gross_sales', 'month', 'advertisers', 'month', 'agencies', 'executives', 'yearly_sales'));
            }
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for weren\'t found'], 400);
    }
}
