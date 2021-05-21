<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-right btn-group">
                <a href="#new-job-modal" data-toggle="modal" class="btn btn-outline-dark" tooltip title="Add Agency" data-placement="bottom"><i class="fas fa-plus"></i></a>
                <a href="#help-job-modal" data-toggle="modal" class="btn btn-outline-dark" tooltip title="Help" data-placement="bottom"><i class="fas fa-question"></i></a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-block d-md-block d-lg-block d-xl-block">
            <div class="card-body">
                <table id="jobsTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Description</th>
                        <th>level</th>
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
<div class="modal fade" id="new-job-modal" tabindex="-1" role="dialog" aria-labelledby="new-job-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-job-form" data-form="Job" data-request="add" action="{{ route('jobs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="job_description">Job Description</label>
                        <input type="text" id="job_description" name="job_description" class="form-control" placeholder="Job Description">
                    </div>
                    <div class="form-group">
                        <label for="level">Job Level</label>
                        <select id="level" name="level" class="custom-select">
                            <option value>--</option>
                            @for($level = 0; $level <= 3; $level++)
                                <option value="{{ $level }}">{{ $level }}</option>
                            @endfor
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

<div class="modal fade" id="update-job-modal" tabindex="-1" role="dialog" aria-labelledby="update-job-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-job-form" data-form="Job" data-request="update" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_job_description">Job Description</label>
                        <input type="text" id="update_job_description" name="job_description" class="form-control" placeholder="Job Description">
                    </div>
                    <div class="form-group">
                        <label for="update_level">Job Level</label>
                        <select id="update_level" name="level" class="custom-select">
                            <option value>--</option>
                            @for($level = 0; $level <= 3; $level++)
                                <option value="{{ $level }}">{{ $level }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="update_is_active">Status</label>
                        <select id="update_is_active" name="is_active" class="custom-select">
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

<div class="modal fade" id="delete-job-modal" tabindex="-1" role="dialog" aria-labelledby="delete-job-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-job-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="delete_job_id" name="job_id">
                    <div id="delete-job-form-body" class="text-center"></div>
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

<!-- Modal -->
<div class="modal fade" id="help-job-modal" tabindex="-1" role="dialog" aria-labelledby="help-job-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-none d-sm-block d-md-block d-lg-block d-xl-block">
                            <table id="legendTable" class="table table-hover" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Legend</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="tableBody">
                                <tr>
                                    <td>Level 0:</td>
                                    <td>Create, Retrieve, Update, Delete</td>
                                </tr>
                                <tr>
                                    <td>Level 1:</td>
                                    <td>Create, Retrieve, Update</td>
                                </tr>
                                <tr>
                                    <td>Level 2:</td>
                                    <td>Create, Retrieve</td>
                                </tr>
                                <tr>
                                    <td>Level 3:</td>
                                    <td>Retrieve</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-block d-sm-none d-md-none d-lg-none d-xl-none">
                            <div class="text-center h4 mb-0">
                                Table display is not available for this device's resolution.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jobsTable = $('#jobsTable').DataTable({
        ajax: {
            url: '{{ route('jobs') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'id' },
            { data: 'job_description' },
            { data: 'level' },
            { data: 'status' },
            { data: 'options' },
        ],
    });

    setInterval(() => {
        jobsTable.ajax.reload(null, false);
    }, 3000);

    $(document).on('submit', '#add-job-form, #update-job-form, #delete-job-form', function(event) {
        event.preventDefault();
        let url = $(this).attr('action');
        let formData = new FormData(this);

        postAsync(url, formData, 'HTML', beforeSend, onSuccess);

        function beforeSend() {
            $('button[type="submit"]').attr('disabled', 'disabled');
            manualToast.fire({
                icon: 'info',
                title: 'Please wait ...'
            });
        }

        function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');
            $('#job_description').val('');
            jobsTable.ajax.reload(null, false);
            $('.modal').modal('hide');

            Toast.fire({
                icon: "success",
                title: "Job has been updated",
            });
        }
    });
</script>
