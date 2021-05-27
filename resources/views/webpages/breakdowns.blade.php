<div class="container">
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="salesTable" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Contract Number</th>
                            <th>BO Number</th>
                            <th>Station</th>
                            <th>Agency</th>
                            <th>Advertiser</th>
                            <th>Account Executive</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr id="tableBody">
                        <td colspan="13">
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

<!-- Modal -->
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

<div class="modal fade" id="update-sale-modal" tabindex="-1" role="dialog" aria-labelledby="update-sales-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-sales-form" data-form="Sales" data-request="update" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="package_cost">
                <input type="hidden" id="package_cost_vat">
                <input type="hidden" id="package_cost_salesdc">
                <input type="hidden" id="prod_cost">
                <input type="hidden" id="prod_cost_vat">
                <input type="hidden" id="prod_cost_salesdc">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bo_number">Broadcast Order Number</label>
                        <input type="text" id="bo_number" name="bo_number" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bo_type">Broadcast Order Type</label>
                        <select id="bo_type" name="bo_type" class="custom-select" readonly>
                            <option value>--</option>
                            <option value="normal">Normal</option>
                            <option value="parent_bo">Parent BO</option>
                            <option value="child_bo">Child BO</option>
                        </select>
                    </div>
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
                        <label for="type">Type of Amount</label>
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
                        <select id="month" name="month" class="custom-select" readonly>
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
                        <input type="text" id="year" name="year" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sale_amount">Amount</label>
                        <input type="number" id="sale_amount" name="amount" class="form-control" min="0" step=".01">
                    </div>
                    <div class="form-group">
                        <label for="sale_gross_amount">Amount Type</label>
                        <input type="number" id="sale_gross_amount" name="gross_amount" class="form-control" readonly min="0" step=".01">
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
    salesTable = $('#salesTable').DataTable({
        ajax: {
            url: '{{ route('sales') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'id' },
            { data: 'contract_number' },
            { data: 'bo_number' },
            { data: 'station' },
            { data: 'agency_name' },
            { data: 'advertiser_name' },
            { data: 'executive' },
            { data: 'options' }
        ],
        order: [
            [ 0, 'desc' ]
        ]
    });

    $('#update-sale-modal, #update-invoice-modal').on('hide.bs.modal', function() {
        $('select').prop('selectedIndex', 0);
        $('#sale_amount, #sale_gross_amount, #invoice_no').val('');
    });

    $(document).on('submit', '#update-sales-form, #update-invoice-form', function(event) {
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
            salesTable.ajax.reload(null, false);
            $('.modal').modal('hide');

            Toast.fire({
                icon: result.status,
                title: result.message,
            });
        }
    });
</script>
