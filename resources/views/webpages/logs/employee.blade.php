<div class="container">
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="employeeLogsTable" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Action Taken</th>
                            <th>Job</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="tableBody">
                            <td colspan="5">
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

<script>
    employeeLogsTable = $('#employeeLogsTable').DataTable({
        ajax: {
            url: '{{ route('logs') }}',
            dataSrc: '',
        },
        columns: [
            { data: 'created_at' },
            { data: 'name' },
            { data: 'action' },
            { data: 'job.job_description' }
        ],
        order: [
            [ 0, 'desc' ]
        ]
    });
</script>
