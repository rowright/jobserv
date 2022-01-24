@extends('app.layout.app')
@section('title')
Work Orders
@endsection
@section('buttons')
@endsection
@section('body')
    <table class="table" id="workOrder">
    <thead>
        <tr>
        <th scope="col">Work Order</th>
        <th scope="col">Job Type</th>
        <th scope="col">Customer</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workOrders as $workOrder)
        <tr>
        <th scope="row"><a href="/workorders/{{ $workOrder->id }}">{{ $workOrder->name }}</a> (#{{ $workOrder->id }})</th>
        <td>{{ $workOrder->JobType->name ?? 'Not Assigned' }}</td>
        <td>{{ $workOrder->Customer->firstname ?? '' }} {{ $workOrder->Customer->lastname ?? '' }}</td>
        <td>{{ Carbon::parse($workOrder->start_at)->format('m/d/y h:i A') }}</td>
        <td>{{ Carbon::parse($workOrder->end_at)->format('m/d/y h:i A') }}</td>
        <td>{{ $workOrder->status }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endsection

@push('scripts')
<script>
    $(document).ready( function () {
        $('#workOrder').DataTable({responsive: true});
    } );
</script>
@endpush
