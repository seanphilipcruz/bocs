<?php

namespace App\Http\Controllers;

use App\Advertiser;
use App\Agency;
use App\Contract;
use App\Employee;
use App\Sales;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Active Contracts
        $contracts = Contract::where('is_active', 1)->get();

        $users = Employee::with('Job')->get();
        $agencies = Agency::where('is_active', 1)->get();
        $advertisers = Advertiser::where('is_active', 1)->get();

        // Get the latest sales of the current year
        $manilaSales = Sales::selectRaw('month, year, sum(gross_amount) as gross_sales')
            ->where('station', 'manila')
            ->where('year', date('Y'))
            ->orderBy('year')
            ->orderBy('month')
            ->groupBy('month','year')
            ->get();

        foreach ($manilaSales as $sales) {
            $date = \DateTime::createFromFormat('!m', $sales->month);

            $sales->month = $date->format('F') . ' ' . $sales->year;
        }

        // manila chart data
        $manilaMonths = $manilaSales->pluck('month')->toArray();
        $manilaGrossSales = $manilaSales->pluck('gross_sales')->toArray();

        // account executives
        $manilaAESales = Sales::with('Employee')->selectRaw('ae, sum(gross_amount) as ae_sales')
            ->where('station', 'manila')
            ->where('year', date('Y'))
            ->groupBy('ae')
            ->get();

        foreach ($manilaAESales as $executives) {
            $executives->name = $executives->Employee->first_name[0] . $executives->Employee->middle_name[0] . $executives->Employee->last_name[0];
        }

        $manilaExecutives = $manilaAESales->pluck('name')->toArray();
        $executiveSales = $manilaAESales->pluck('ae_sales')->toArray();

        // yearly sales
        $manilaYearlySales = Sales::selectRaw('year, sum(gross_amount) as gross_sales')
            ->where('station', 'manila')
            ->orderBy('year')
            ->groupBy('year')
            ->get();

        $manilaYears = $manilaYearlySales->pluck('year')->toArray();
        $manilaYearlyGrossSales = $manilaYearlySales->pluck('gross_sales')->toArray();
        // end


        // Get the latest sales of the current year
        $cebuSales = Sales::selectRaw('month, year, sum(gross_amount) as gross_sales')
            ->where('station', 'cebu')
            ->where('year', date('Y'))
            ->orderBy('year')
            ->orderBy('month')
            ->groupBy('month','year')
            ->get();

        foreach ($cebuSales as $sales) {
            $date = \DateTime::createFromFormat('!m', $sales->month);

            $sales->month = $date->format('F');
        }

        // cebu chart data
        $cebuMonths = $cebuSales->pluck('month')->toArray();
        $cebuGrossSales = $cebuSales->pluck('gross_sales')->toArray();;

        // account executives
        $cebuAESales = Sales::with('Employee')->selectRaw('ae, sum(gross_amount) as ae_sales')
            ->where('station', 'cebu')
            ->where('year', date('Y'))
            ->groupBy('ae')
            ->get();

        foreach ($cebuAESales as $executives) {
            $executives->name = $executives->Employee->first_name[0] . $executives->Employee->middle_name[0] . $executives->Employee->last_name[0];
        }

        $cebuExecutives = $cebuAESales->pluck('name')->toArray();
        $cebuExecutiveSales = $cebuAESales->pluck('ae_sales')->toArray();

        // yearly sales
        $cebuYearlySales = Sales::selectRaw('year, sum(gross_amount) as gross_sales')
            ->where('station', 'cebu')
            ->orderBy('year')
            ->groupBy('year')
            ->get();

        $cebuYears = $cebuYearlySales->pluck('year')->toArray();
        $cebuYearlyGrossSales = $cebuYearlySales->pluck('gross_sales')->toArray();
        // end


        // Get the latest sales of the current year
        $davaoSales = Sales::selectRaw('month, year, sum(gross_amount) as gross_sales')
            ->where('station', 'davao')
            ->where('year', date('Y'))
            ->orderBy('year')
            ->orderBy('month')
            ->groupBy('month','year')
            ->get();

        foreach ($davaoSales as $sales) {
            $date = \DateTime::createFromFormat('!m', $sales->month);

            $sales->month = $date->format('F');
        }

        // davao chart data
        $davaoMonths = $davaoSales->pluck('month')->toArray();
        $davaoGrossSales = $davaoSales->pluck('gross_sales')->toArray();

        // account executives
        $davaoAESales = Sales::with('Employee')->selectRaw('ae, sum(gross_amount) as ae_sales')
            ->where('station', 'davao')
            ->where('year', date('Y'))
            ->groupBy('ae')
            ->get();

        foreach ($davaoAESales as $executives) {
            $executives->name = $executives->Employee->first_name[0] . $executives->Employee->middle_name[0] . $executives->Employee->last_name[0];
        }

        $davaoExecutives = $davaoAESales->pluck('name')->toArray();
        $davaoExecutiveSales = $davaoAESales->pluck('ae_sales')->toArray();

        // yearly sales
        $davaoYearlySales = Sales::selectRaw('year, sum(gross_amount) as gross_sales')
            ->where('station', 'davao')
            ->orderBy('year')
            ->groupBy('year')
            ->get();

        $davaoYears = $davaoYearlySales->pluck('year')->toArray();
        $davaoYearlyGrossSales = $davaoYearlySales->pluck('gross_sales')->toArray();
        // end

        $data = [
            'manilaMonths' => $manilaMonths,
            'manilaGrossSales' => $manilaGrossSales,
            'manilaExecutives' => $manilaExecutives,
            'manilaAESales' => $executiveSales,
            'manilaYears' => $manilaYears,
            'manilaYearlyGrossSales' => $manilaYearlyGrossSales,
            // for cebu data
            'cebuMonths' => $cebuMonths,
            'cebuGrossSales' => $cebuGrossSales,
            'cebuExecutives' => $cebuExecutives,
            'cebuAESales' => $cebuExecutiveSales,
            'cebuYears' => $cebuYears,
            'cebuYearlyGrossSales' => $cebuYearlyGrossSales,
            // for davao data
            'davaoMonths' => $davaoMonths,
            'davaoGrossSales' => $davaoGrossSales,
            'davaoExecutives' => $davaoExecutives,
            'davaoAESales' => $davaoExecutiveSales,
            'davaoYears' => $davaoYears,
            'davaoYearlyGrossSales' => $davaoYearlyGrossSales,
        ];

        // get the provincial sales


        return view('home', compact('users', 'contracts', 'agencies', 'advertisers', 'data'));
    }
}
