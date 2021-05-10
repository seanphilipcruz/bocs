<?php

namespace App\Http\Controllers;

use App\ContractRevision;
use App\SalesRevision;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request) {
        $archives = ContractRevision::with('Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->get();

        foreach ($archives as $archive) {
            $archive->options = "" .
                "<a href='#compare-modal' data-toggle='modal' data-action='compare' data-compare='contract' data-link='".route('archives.show', $archive->id)."' tooltip data-placement='bottom' title='Compare' class='btn btn-outline-dark'>" .
                "   <i class='fas fa-exchange-alt'></i>" .
                "</a>";
        }

        if($request->ajax()) {
            if($request['action'] === 'switch') {
                $archives = SalesRevision::with('Sales.Contract.Agency', 'Sales.Contract.Advertiser', 'Sales.Contract.Employee')->get();

                foreach($archives as $archive) {
                    $archive->options = "" .
                        "<a href='#compare-sales-modal' data-toggle='modal' data-action='compare' data-compare='sale' data-link='".route('archives.show', $archive->id)."' tooltip data-placement='bottom' title='Compare' class='btn btn-outline-dark'>" .
                        "   <i class='fas fa-exchange-alt'></i>" .
                        "</a>";
                }

                if($request['switch'] === 'sales') {
                    return view('webpages.archive.sales');
                }
            }

            if($request['navigation']) {
                return view('webpages.archive.contracts');
            }

            return $archives;
        }

        return response()->json(['status' => 'error', 'message' => 'Webpage you were looking for wasn\'t found'], 403);
    }

    public function show($id, Request $request) {
        if($request['type'] === "sale") {
            $archive = SalesRevision::with('Sales.Contract.Agency', 'Sales.Contract.Advertiser', 'Sales.Contract.Employee')->findOrFail($id);

            return view('webpages.archive.sales_compare', compact('archive'));
        }

        $archive = ContractRevision::with('Agency', 'Advertiser', 'Employee', 'Contract.Agency', 'Contract.Advertiser', 'Contract.Employee')->findOrFail($id);

        return view('webpages.archive.contracts_compare', compact('archive'));
    }
}
