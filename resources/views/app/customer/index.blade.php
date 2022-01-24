@extends('app.layout.app')
@section('title')
Customers
@endsection
@section('buttons')
<a href="/customers/new" class="btn btn-success" role="button">New Customer</a>
@endsection
@section('body')
    <table class="table" id="customer">
    <thead>
        <tr>
        <th scope="col">Customer</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Address</th>
        <th scope="col">City</th>
        <th scope="col">State</th>
        <th scope="col">Zip</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
        <th scope="row"><a href="/customers/{{ $customer->id }}">{{ $customer->firstname }} {{$customer->lastname}} @if($customer->companyname)({{$customer->companyname}})@endif</a></th>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->phone1 }}</td>
        <td>{{ $customer->address1 }} {{ $customer->address2 }}</td>
        <td>{{ $customer->city }}</td>
        <td>{{ $customer->state }}</td>
        <td>{{ $customer->postcode }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endsection

@push('scripts')
<script>
    $(document).ready( function () {
        $('#customer').DataTable({responsive: true});
    } );
</script>
@endpush
