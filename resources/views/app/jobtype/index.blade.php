@extends('app.layout.app')
@section('title')
Job Types
@endsection
@section('buttons')
<a href="/jobtypes/new" class="btn btn-success" role="button">New Job Types</a>
@endsection
@section('body')
    <table class="table" id="user">
    <thead>
        <tr>
        <th scope="col">Job Type</th>
        <th scope="col">Path</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jobTypes as $jobType)
        <tr>
        <th scope="row"><a href="/jobtypes/{{ $jobType->id }}">{{ $jobType->name }}</a></th>
        <td>{{ $jobType->name_path }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endsection

@push('scripts')
<script>
    $(document).ready( function () {
        $('#user').DataTable({responsive: true});
    } );
</script>
@endpush
