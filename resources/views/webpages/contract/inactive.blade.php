<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-left">
                <a href="{{ route('contracts') }}" id="contracts" class="btn btn-outline-dark" navigation title="Switch to active contracts"><i class="fas fa-exchange-alt"></i>  Active</a>
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

<script type="text/javascript">
    // datatable
    contractsTable = $('#contractsTable').DataTable({
        ajax: {
            url: '{{ route('contracts') }}',
            dataSrc: '',
            data: {
                "inactive": true
            }
        },
        columns: [
            { data: 'id' },
            { data: 'contract_number' },
            { data: 'bo_number' },
            { data: 'station' },
            { data: 'advertiser_name' },
            { data: 'agency_name' },
            { data: 'print_status' },
            { data: 'options' }
        ],
        order: [
            [ 0, 'desc' ]
        ]
    });

    $(document).on('submit', '#update-contract-form', function(event) {
        event.preventDefault();
    });

    $(document).on('submit', '#delete-contract-form', function(event) {
        event.preventDefault();
        let url = $(this).attr('action');
        let formData = new FormData(this);

        postAsync(url, formData, 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            manualToast.fire({
                icon: 'info',
                message: 'Please wait ...'
            });
        }

        function onSuccess(result) {
            contractsTable.ajax.reload(null, false);

            Toast.fire({
                icon: result.status,
                message: result.message
            });
        }
    })
</script>
