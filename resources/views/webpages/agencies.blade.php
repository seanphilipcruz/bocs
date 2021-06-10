<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-right btn-group">
                <a href="#new-agency-modal" data-toggle="modal" class="btn btn-outline-dark" tooltip title="Add Agency" data-placement="bottom"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-block d-md-block d-lg-block d-xl-block">
            <div class="card-body">
                <table id="agenciesTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>KBP Status</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="tableBody">
                        <td colspan="7">
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
<div class="modal fade" id="new-agency-modal" tabindex="-1" role="dialog" aria-labelledby="new-agency-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Agency</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-agency-form" data-form="Agency" data-request="add" action="{{ route('agencies.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="agency_name">Agency Name</label>
                        <input type="text" id="agency_name" name="agency_name" class="form-control" placeholder="Agency Name">
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Contact Number">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="kbp_accredited">KBP Status</label>
                        <select id="kbp_accredited" name="kbp_accredited" class="custom-select">
                            <option value="">--</option>
                            <option value="1">Accredited</option>
                            <option value="0">Non-Accredited</option>
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

<div class="modal fade" id="update-agency-modal" tabindex="-1" role="dialog" aria-labelledby="update-agency-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Agency</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-agency-form"data-form="Agency" data-request="update"  action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_agency_name">Agency Name</label>
                        <input type="text" id="update_agency_name" name="agency_name" class="form-control" placeholder="Agency Name">
                    </div>
                    <div class="form-group">
                        <label for="update_contact_number">Contact Number</label>
                        <input type="text" id="update_contact_number" name="contact_number" class="form-control" placeholder="Contact Number">
                    </div>
                    <div class="form-group">
                        <label for="update_address">Address</label>
                        <input type="text" id="update_address" name="address" class="form-control" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="update_kbp_accredited">KBP Status</label>
                        <select id="update_kbp_accredited" name="kbp_accredited" class="custom-select">
                            <option value="">--</option>
                            <option value="1">Accredited</option>
                            <option value="0">Non-Accredited</option>
                        </select>
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

<div class="modal fade" id="delete-agency-modal" tabindex="-1" role="dialog" aria-labelledby="delete-agency-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Agency</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-agency-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="delete_agency_id" name="agency_id">
                    <div id="delete-agency-form-body" class="text-center"></div>
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
    $(document).off('submit');
    // datatable
    agenciesTable = $('#agenciesTable').DataTable({
        ajax: {
            url: '{{ route('agencies') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'agency_code' },
            { data: 'agency_name' },
            { data: 'address' },
            { data: 'contact_number' },
            { data: 'kbp_status' },
            { data: 'status' },
            { data: 'options' }
        ],
        order: [
            [ 1, 'asc']
        ]
    });

    setInterval(() => {
        agenciesTable.ajax.reload(null, false);
    }, 3000);

    // form processing
    $(document).on('submit', '#add-agency-form, #update-agency-form, #delete-agency-form', function(event) {
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
            $('#agency_name, #contact_number, #address').val('');
            agenciesTable.ajax.reload(null, false);
            $('.modal').modal('hide');

            Toast.fire({
                icon: result.status,
                title: result.message,
            });
        }
    });
</script>
