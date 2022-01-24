@extends('app.layout.app')
@section('title')
Users
@endsection
@section('buttons')
<a href="/users/new" class="btn btn-success" role="button">New User</a>
@endsection
@section('body')
    <table class="table" id="user">
    <thead>
        <tr>
        <th scope="col">User</th>
        <th scope="col">Email</th>
        <th scope="col">Worker</th>
        <th scope="col">Customer</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
        <th scope="row"><a href="/users/{{ $user->id }}">{{ $user->name }}</a></th>
        <td>{{ $user->email }}</td>
        <td>@if($user->Worker)<a href="/workers/{{ $user->Worker->id }}">{{ $user->Worker->firstname }} {{ $user->Worker->lastname }}</a>@else Not Linked @endif</td>
        <td>@if($user->Customer)<a href="/customers/{{ $user->Customer->id }}">{{ $user->Customer->firstname }} {{ $user->Customer->lastname }}</a>@else Not Linked @endif</td>
        <td>@if(Auth::user()->id !== $user->id)<a href="/users/{{ $user->id }}/delete">Delete</a>@endif</td>
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
