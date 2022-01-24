@extends('app.layout.app')
@section('title')
Workers
@endsection
@section('buttons')
<a href="/workers/new" class="btn btn-success" role="button">New Worker</a>
@endsection
@section('body')
    <table class="table" id="worker">
    <thead>
        <tr>
        <th scope="col">Display Name</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Team</th>
        <th scope="col">Active?</th>
        </tr>
    </thead>
    <tbody>
        @foreach($workers as $worker)
        <tr>
        <th scope="row"><a href="/workers/{{ $worker->id }}">{{ $worker->displayname }}</a></th>
        <td>{{ $worker->firstname }} {{ $worker->lastname }}</td>
        <td>{{ $worker->email }}</td>
        <td>{{ $worker->phone }}</td>
        <td>{{ $worker->team }}</td>
        <td>@if($worker->is_active) Active @else Inactive @endif</td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endsection

@push('scripts')
<script>
    $(document).ready( function () {
        $('#worker').DataTable({responsive: true});
    } );
</script>
@endpush
