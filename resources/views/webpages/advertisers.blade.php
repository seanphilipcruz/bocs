<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-right btn-group">
                <a href="#new-advertiser-modal" data-toggle="modal" class="btn btn-outline-dark" tooltip title="Add Advertiser" data-placement="bottom"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-block d-md-block d-lg-block d-xl-block">
            <div class="card-body">
                <table id="advertisersTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="tableBody">
                        <td colspan="4">
                            <div class="alert alert-danger m-0 text-center">
                                No Data Found
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-block d-sm-none d-md-none d-lg-none d-xl-none">
            <div class="text-center h4 mb-0">
                Table display is not available for this device's resolution.
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="new-advertiser-modal" tabindex="-1" role="dialog" aria-labelledby="new-advertiser-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Advertiser</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-advertiser-form" data-form="Advertiser" data-request="add"  action="{{ route('advertisers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="advertiser_name">Advertiser Name</label>
                        <input type="text" id="advertiser_name" name="advertiser_name" class="form-control" placeholder="Advertiser Name">
                    </div>
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

<div class="modal fade" id="update-advertiser-modal" tabindex="-1" role="dialog" aria-labelledby="update-advertiser-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Advertiser</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-advertiser-form" data-form="Advertiser" data-request="update"  action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_advertiser_name">Advertiser Name</label>
                        <input type="text" id="update_advertiser_name" name="advertiser_name" class="form-control" placeholder="Advertiser Name">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select id="is_active" name="is_active" class="custom-select">
                            <option value=>--</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
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

<div class="modal fade" id="delete-advertiser-modal" tabindex="-1" role="dialog" aria-labelledby="delete-advertiser-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Advertiser</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-advertiser-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="delete_advertiser_id" name="advertiser_id">
                    <div id="delete-employee-form-body" class="text-center"></div>
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
    advertisersTable = $('#advertisersTable').DataTable({
        ajax: {
            url: '{{ route('advertisers') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'advertiser_code' },
            { data: 'advertiser_name' },
            { data: 'status' },
            { data: 'options' }
        ],
        order: [
            [ 1, 'asc' ]
        ]
    });

    setInterval(() => {
        advertisersTable.ajax.reload(null, false);
    }, 3000);

    // form processes
    $(document).on('submit', '#add-advertiser-form ,#update-advertiser-form, #delete-advertiser-form', function(event) {
        event.preventDefault();
        let url = $(this).attr('action');
        let formData = new FormData(this);

        postAsync(url, formData, 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            $('button[type="submit"]').attr('disabled', 'disabled');
            manualToast.fire({
                icon: 'info',
                title: 'Please wait ...'
            });
        }

        function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');
            $('#advertiser_name').val('');
            advertisersTable.ajax.reload(null, false);
            $('.modal').modal('hide');

            Toast.fire({
                icon: result.status,
                title: result.message,
            });
        }
    });
</script>
