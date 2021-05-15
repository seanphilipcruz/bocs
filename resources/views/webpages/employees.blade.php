<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="fa-pull-right btn-group">
                <a href="#new-employee-modal" data-toggle="modal" class="btn btn-outline-dark" tooltip title="Add Employee" data-placement="bottom"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="employeesTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Last</th>
                        <th>First</th>
                        <th>Username</th>
                        <th>Job</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="tableBody">
                        <td colspan="12">
                            <div class="alert alert-danger m-0 lead text-center">
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
<div class="modal fade" id="new-employee-modal" role="dialog" aria-labelledby="new-employee-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="new-employee-form" data-form="Employee" data-request="add"  action="{{ route('employees.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control" placeholder="Middle Name">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="nickname">Nickname</label>
                            <input type="text" id="nickname" name="nickname" class="form-control" placeholder="Nickname">
                        </div>
                        <div class="col">
                            <label for="job_id">Job Title</label>
                            <select id="job_id" name="job_id" class="custom-select">
                                <option value="">--</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="date_of_birth">Birthday</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-control">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="username">Username</label>
                            <input type="email" id="username" name="username" class="form-control" placeholder="Username">
                        </div>
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

<div class="modal fade" id="update-employee-modal" role="dialog" aria-labelledby="new-employee-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-employee-form" data-form="Employee" data-request="update"  action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="update_first_name">First Name</label>
                            <input type="text" id="update_first_name" name="first_name" class="form-control" placeholder="First Name">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="update_middle_name">Middle Name</label>
                            <input type="text" id="update_middle_name" name="middle_name" class="form-control" placeholder="Middle Name">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="update_last_name">Last Name</label>
                            <input type="text" id="update_last_name" name="last_name" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="update_username">Username</label>
                            <input type="email" id="update_username" name="username" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="update_nickname">Nickname</label>
                            <input type="text" id="update_nickname" name="nickname" class="form-control" placeholder="Nickname">
                        </div>
                        <div class="col">
                            <label for="update_birthdate">Date of Birth</label>
                            <input type="date" id="update_birthdate" name="date_of_birth" class="form-control">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="update_job_id">Job Title</label>
                            <select id="update_job_id" name="job_id" class="custom-select">
                                <option value="">--</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="is_active">Status</label>
                            <select id="is_active" name="is_active" class="custom-select">
                                <option value="">--</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-3"></div>
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

<div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="change-password-form" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="current_password">Current</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="password">New</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="New Password">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <div class="row">
                        <div class="col">
                            <label for="password_confirmation">Repeat</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="my-3"></div>
                    <input type="hidden" id="employee_id" name="employee_id">
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

<div class="modal fade" id="delete-employee-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-employee-form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="delete_employee_id" name="employee_id">
                    <div id="delete-employee-form-body" class="text-center"></div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-outline-dark"><i class="fas fa-check"></i></button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // datatable
    employeesTable = $('#employeesTable').DataTable({
        ajax: {
            url: '{{ route('employees') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'id' },
            { data: 'last_name' },
            { data: 'first_name' },
            { data: 'username' },
            { data: 'job.job_description' },
            { data: 'status' },
            { data: 'options' }
        ],
        order: [
            [ 5, 'asc' ]
        ]
    });

    // form processing
    $(document).on('submit', '#new-employee-form, #update-employee-form, #delete-employee-form, #change-password-form', function(event) {
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
            $('#first_name, #middle_name, #last_name, #nickname, #username, #date_of_birth').val('');
            employeesTable.ajax.reload(null, false);
            $('.modal').modal('hide');

            Toast.fire({
                icon: result.status,
                title: result.message,
            });
        }
    });

    // loading jobs data
    function loadJobs() {
        getAsync('{{ route('jobs') }}', null, 'JSON', beforeSend, onSuccess);

        function beforeSend() {

        }

        function onSuccess(result) {
            let options = "";

            for (let i = 0; i < result.length; i++) {
                options += '<option value="'+result[i].id+'">'+result[i].job_description+'</option>';
            }

            $('#job_id, #update_job_id').empty();
            $('#job_id, #update_job_id').append(options);
        }
    }

    loadJobs();
</script>
