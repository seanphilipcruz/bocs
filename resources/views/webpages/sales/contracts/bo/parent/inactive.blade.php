<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group fa-pull-left">
                <a href="#" class="btn btn-outline-dark" data-action="switch" data-switch="parent" data-link="{{ route('sales') }}" title="Switch to non-active contracts"><i class="fas fa-exchange-alt"></i>  Active</a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="contractSalesTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Contract Number</th>
                        <th>BO Number</th>
                        <th>Advertiser</th>
                        <th>Agency</th>
                        <th>Total Amount</th>
                        <th>Breakdown Amount</th>
                        <th>Total Prod</th>
                        <th>Breakdown Prod</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="tableBody">
                        <td colspan="10">
                            <div class="alert alert-danger m-0 text-center">
                                No Data Found
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
            <div class="text-center h4 mb-0">
                Table display is not available for this device's resolution.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-sales-breakdown-modal" tabindex="-1" role="dialog" aria-labelledby="add-sales-breakdown-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sales Breakdown</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-sales-breakdown-form" data-form="Sales Breakdown" data-request="add" action="{{ route('sales.store') }}" method="POST">
                @csrf
                <input type="hidden" id="package_cost">
                <input type="hidden" id="package_cost_vat">
                <input type="hidden" id="package_cost_salesdc">
                <input type="hidden" id="prod_cost">
                <input type="hidden" id="prod_cost_vat">
                <input type="hidden" id="prod_cost_salesdc">
                <input type="hidden" id="bo_number" name="bo_number">
                <div class="modal-body">
                    <div class="mb-3">Broadcast Order Number: <span id="bo_number_text" class="text-primary">undefined</span></div>
                    <div class="form-group">
                        <label for="station">Station</label>
                        <select id="station" name="station" class="custom-select">
                            <option value>--</option>
                            <option value="Manila">Manila</option>
                            <option value="Cebu">Cebu</option>
                            <option value="Davao">Davao</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" class="custom-select">
                            <option value>--</option>
                            <option value="airtime">Air Time</option>
                            <option value="top10">Top 10 Sponsorship</option>
                            <option value="live">Live Guesting/Interview</option>
                            <option value="DJDisc">DJ Discussion</option>
                            <option value="spots">Spots</option>
                            <option value="totalprod">Production</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount_type">Type of Cash</label>
                        <select id="amount_type" name="amount_type" class="custom-select">
                            <option value>--</option>
                            <option value="Cash">Cash</option>
                            <option value="Ex-deal">Ex-Deal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="month">Month</label>
                        <select id="month" name="month" class="custom-select">
                            <option value>--</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <select id="year" name="year" class="custom-select">
                            <option value>--</option>
                            @for($i = date('Y'); $i <= 2100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <hr class="my-4">
                    <div class="form-group">
                        <label for="sale_amount">Amount</label>
                        <input type="text" id="sale_amount" name="amount" class="form-control" placeholder="Amount" onchange="findSalesTotal()">
                    </div>
                    <div class="form-group">
                        <input type="text" id="sale_gross_amount" name="gross_amount" class="form-control" value="Gross Amount" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-outline-dark">Save</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="update-invoice-modal" tabindex="-1" role="dialog" aria-labelledby="update-invoice-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Invoice Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-invoice-form" data-form="Invoice" data-request="update" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="invoice_no">Invoice Number</label>
                        <input type="text" id="invoice_no" name="invoice_no" class="form-control" placeholder="Invoice Number">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-outline-dark">Save</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    contractSalesTable = $('#contractSalesTable').DataTable({
        ajax: {
            url: '{{ route('sales') }}',
            dataSrc: '',
            data: {
                "inactive_parent": true,
                "contract_sales": true,
            }
        },
        columns: [
            { data: 'id' },
            { data: 'contract_number' },
            { data: 'short_bo_number' },
            { data: 'advertiser_name' },
            { data: 'agency_name' },
            { data: 'total' },
            { data: 'total_breakdown' },
            { data: 'prod' },
            { data: 'total_prod_breakdown' },
            { data: 'options' },
        ],
        order: [
            [ 0, 'desc' ],
        ]
    });
</script>
