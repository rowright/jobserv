@extends('app.layout.app')
@section('title')
Work Order Details - #{{ $workOrder->id }}
@endsection
@section('buttons')
<a href="/workorders/{{ $workOrder->id }}" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Job Name', 'name', $workOrder->name) !!}
{!! BootForm::text('Address 1', 'address1', $workOrder->address1) !!}
{!! BootForm::text('Address 2', 'address2', $workOrder->address2) !!}
{!! BootForm::text('City', 'city', $workOrder->city) !!}
{!! BootForm::text('State', 'state', $workOrder->state) !!}
{!! BootForm::text('Zip Code', 'postcode', $workOrder->postcode) !!}
{!! BootForm::text('Scheduled Start At', 'start_at', $workOrder->start_at) !!}
{!! BootForm::text('Scheduled End At', 'end_at', $workOrder->end_at) !!}
{!! BootForm::select('Status', 'status')->options($statuses)->select($workOrder->status) !!}
{!! BootForm::select('Job Type', 'job_type_id')->options($jobTypes)->select($workOrder->job_type_id) !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
