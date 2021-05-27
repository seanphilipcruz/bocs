<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group fa-pull-left">
                <a href="#" class="btn btn-outline-dark" data-action="switch" data-switch="inactive" data-link="{{ route('contracts') }}" title="Switch to non-active contracts"><i class="fas fa-exchange-alt"></i>  Inactive</a>
                <a href="#" class="btn btn-outline-dark" data-action="switch" data-switch="parent" data-link="{{ route('contracts') }}" title="Switch to Parent BO"><i class="fas fa-folder-plus"></i>  Parent BO</a>
                <a href="#" class="btn btn-outline-dark" data-action="switch" data-switch="child_bo" data-link="{{ route('contracts') }}" title="Switch to Child BO"><i class="fas fa-folder-minus"></i>  Child BO</a>
            </div>
            <div class="fa-pull-right btn-group">
                <a href="#" class="btn btn-outline-dark" data-action='create' data-link='{{ route('contracts.create') }}'><i class="fas fa-plus"></i>  New Contract</a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="contractsTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Contract Number</th>
                        <th>BO Number</th>
                        <th>Station</th>
                        <th>Advertiser</th>
                        <th>Agency</th>
                        <th>Executive</th>
                        <th>Print Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="tableBody">
                        <td colspan="8">
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

<!-- Modals -->
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

<div class="modal fade" id="contract-status-modal" tabindex="-1" role="dialog" aria-labelledby="contract-status-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="contract-status-title" class="modal-title">Undefined</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="contract-status-form" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="contract_status_id" name="contract_id">
                    <div id="contract-status-form-body" class="text-center"></div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button id="contract-status-button" type="submit" class="btn btn-outline-dark">Activate</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-contract-modal" tabindex="-1" role="dialog" aria-labelledby="delete-contract-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Contract</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-contract-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="delete_contract_id" name="contract_id">
                    <div id="delete-contract-form-body" class="text-center"></div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-outline-dark"><i class="fas fa-save"></i></button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </form>
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
                <input type="hidden" id="contract_id" name="contract_id">
                <input type="hidden" id="bo_type" name="bo_type">
                <input type="hidden" id="agency_id" name="agency_id">
                <input type="hidden" id="advertiser_id" name="advertiser_id">
                <input type="hidden" id="employee_id" name="ae">
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
                        <input type="number" id="sale_amount" name="amount" class="form-control" placeholder="Amount" min="0" step=".01">
                    </div>
                    <div class="form-group">
                        <input type="number" id="sale_gross_amount" name="gross_amount" class="form-control" value="Gross Amount" readonly min="0" step=".01">
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

<script type="text/javascript">
    // datatable
    contractsTable = $('#contractsTable').DataTable({
        ajax: {
            url: '{{ route('contracts') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'id' },
            { data: 'short_contract_number' },
            { data: 'short_bo_number' },
            { data: 'station' },
            { data: 'advertiser_name' },
            { data: 'agency_name' },
            { data: 'employee_name' },
            { data: 'print_status' },
            { data: 'options' }
        ],
        order: [
            [ 0, 'desc']
        ]
    });

    $('#add-sales-breakdown-modal, #update-invoice-modal').on('hide.bs.modal', function() {
        $('select').prop('selectedIndex', 0);
        $('#sale_amount, #sale_gross_amount').val('');
    });

    $(document).on('submit', '#add-sales-breakdown-form, #update-invoice-form', function(event) {
        event.preventDefault();

        let url = $(this).attr('action');
        let formData = new FormData(this);
        let formType = $(this).attr('data-form');

        postAsync(url, formData, 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            manualToast.fire({
                icon: 'info',
                title: 'Please wait ...'
            });
        }

        function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');
            contractsTable.ajax.reload(null, false);
            $('.modal').modal('hide');
            $('select').prop('selectedIndex', 0);
            $('#sale_amount, #sale_gross_amount').val('');

            Toast.fire({
                icon: result.status,
                title: "A new " +formType+ " has been saved!",
            });
        }
    });

    $(document).on('submit', '#contract-status-form, #delete-contract-form', function(event) {
        event.preventDefault();
        let url = $(this).attr('action');
        let formData = new FormData(this);

        postAsync(url, formData, 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            manualToast.fire({
                icon: 'info',
                title: 'Please wait ...'
            });
        }

        function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');
            contractsTable.ajax.reload(null, false);
            $('.modal').modal('hide');

            Toast.fire({
                icon: result.status,
                title: result.message
            });
        }
    });
</script>
