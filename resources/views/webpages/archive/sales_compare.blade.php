<div class="row">
    <div class="col-md-12">
        <table class="table table-hover">
            <tr>
                <th>Name</th>
                <th>Old Version</th>
                <th>New Version</th>
            </tr>
            <tr>
                <td>Amount</td>
                @if($archive->Sales->amount !== $archive->amount)
                    <td class="text-primary">{{ $archive->amount }}</td>
                    <td class="text-primary">{{ $archive->Sales->amount }}</td>
                @else
                    <td>{{ $archive->amount }}</td>
                    <td>{{ $archive->Sales->amount }}</td>
                @endif
            </tr>
            <tr>
                <td>Gross Amount</td>
                @if($archive->Sales->gross_amount !== $archive->gross_amount)
                    <td class="text-primary">{{ $archive->gross_amount }}</td>
                    <td class="text-primary">{{ $archive->Sales->gross_amount }}</td>
                @else
                    <td>{{ $archive->gross_amount }}</td>
                    <td>{{ $archive->Sales->gross_amount }}</td>
                @endif
            </tr>
        </table>
    </div>
</div>
