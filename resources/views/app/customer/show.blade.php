@extends('app.layout.app')
@section('title')
Customer Details - {{ $customer->firstname }} {{ $customer->lastname }}
@endsection
@section('buttons')
<a href="/customers" class="btn btn-primary" role="button">Go back</a>
<a href="/customers/{{$customer->id}}/edit" class="btn btn-warning" role="button">Edit</a>
<a href="/workorders/new/{{$customer->id}}" class="btn btn-success" role="button">New Work Order</a>
@endsection
@section('body')

<div class="row mb-2">
    <div class="col-md-6">
    <h5>Customer</h5>
    <div class="card">
        <div class="card-body">
        <h5 class="card-title">{{ $customer->firstname }} {{ $customer->lastname }} @if($customer->companyname) ({{$customer->companyname}}) @endif</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $customer->email }}</h6>
            {{ $customer->address1 }}<br/>
            @if($customer->address2)
            {{ $customer->address2 }}<br/>
            @endif
            {{ $customer->city }}, {{ $customer->state }} {{ $customer->postcode }}<br/>
            <a href="tel:{{ $customer->phone1 }}">{{ $customer->phone1 }}</a><br/>
            <a href="tel:{{ $customer->phone2 }}">{{ $customer->phone2 }}</a>
        </div>
    </div>
    </div>
</div>
<h5>Work Orders</h5>
<ul>
    @foreach($customer->WorkOrder->sortByDesc('start_at') as $workOrder)
    
    <li><a href="/workorders/{{ $workOrder->id}}">{{ $workOrder->name }} ({{ $workOrder->JobType->name }}) @ {{ $workOrder->start_at }}</a></li>
        @endforeach
        
</ul>
@endsection
