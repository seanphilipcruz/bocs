<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-right btn-group">
                <a href="{{ route('archives') }}" id="archives" class="btn btn-outline-dark" navigation><i class="fas fa-exchange-alt"></i> Contracts</a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="salesArchive" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>BO Number</th>
                        <th>Version</th>
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
<div class="modal fade" id="compare-sales-modal" tabindex="-1" role="dialog" aria-labelledby="compare-sales-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Compare Sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="compare-sales-modal-body" class="modal-body">
                <div class="text-center">Undefined</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    salesArchiveTable = $('#salesArchive').DataTable({
        ajax: {
            url: '{{ route('archives') }}',
            dataSrc: '',
            data: {
                "action": "switch"
            }
        },
        columns: [
            { data: 'id' },
            { data: 'sales.contract.bo_number' },
            { data: 'version' },
            { data: 'options' },
        ]
    });
</script>
