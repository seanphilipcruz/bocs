<div class="container">
    <div class="my-3"></div>
    <div class="justify-content-center">
        <div class="card d-none d-sm-none d-md-none d-lg-block d-xl-block">
            <div class="card-body">
                <table id="contractLogsTable" class="table table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Contract Number</th>
                        <th>BO Number</th>
                        <th>Action Taken</th>
                        <th>Employee Name</th>
                        <th>Date Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $contracts)
                        <tr>
                            <td>{{ $contracts->id }}</td>
                            <td>{{ $contracts->Contract->contract_number }}</td>
                            <td>{{ $contracts->Contract->bo_number }}</td>
                            <td>{{ $contracts->action }}</td>
                            <td>{{ $contracts->Contract->Employee->first_name }} {{ $contracts->Contract->Employee->last_name }}</td>
                            <td>{{ $contracts->created_at }}</td>
                        </tr>
                    @empty
                    @endforelse
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
    contractLogsTable = $('#contractLogsTable').DataTable({
        order: [
            [ 0, 'desc' ]
        ]
    });
</script>
