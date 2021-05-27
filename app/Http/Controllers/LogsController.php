<?php

namespace App\Http\Controllers;

use App\AccountExecutiveLogs;
use App\AgencyAdvertiserLogs;
use App\EmployeeLogs;
use App\SalesLogs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(Request $request) {
        $logs = EmployeeLogs::with('User', 'Employee', 'Job')->get();

        foreach ($logs as $employee) {
            $employee->name = $employee->User->first_name . ' ' . $employee->User->last_name;
        }

        if($request->ajax()) {
            $query = $request['logs'];

            if(preg_match( '/contract/', $query) === 1) {
                $logs = AccountExecutiveLogs::with('Contract', 'Employee')->get();

                return view('webpages.logs.contract', compact('logs'));
            }

            if(preg_match('/sales/', $query) === 1) {
                $logs = SalesLogs::with('Sales', 'Employee')->get();

                return view('webpages.logs.sales_breakdown', compact('logs'));
            }

            if(preg_match( '/advertiser/', $query) === 1) {
                $logs = AgencyAdvertiserLogs::with('Advertiser', 'Employee')->whereNull('agency_id')->get();

                return view('webpages.logs.advertiser', compact('logs'));
            }

            if (preg_match( '/agency/', $query) === 1) {
                $logs = AgencyAdvertiserLogs::with('Agency', 'Employee')->whereNull('advertiser_id')->get();

                return view('webpages.logs.agency', compact('logs'));
            }

            if(preg_match('/employees/', $query) === 1) {
                return view('webpages.logs.employee');
            }

            return $logs;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }
}
