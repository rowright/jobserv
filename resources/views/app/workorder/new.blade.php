@extends('app.layout.app')
@section('title')
New Work Order for {{ $customer->firstname }} {{ $customer->lastname }}
@endsection
@section('buttons')
<a href="/customers/{{ $customer->id }}" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Job Name', 'name') !!}
{!! BootForm::text('Address 1', 'address1', $customer->address1) !!}
{!! BootForm::text('Address 2', 'address2', $customer->address1) !!}
{!! BootForm::text('City', 'city', $customer->city) !!}
{!! BootForm::text('State', 'state', $customer->state) !!}
{!! BootForm::text('Zip Code', 'postcode', $customer->postcode) !!}
{!! BootForm::text('Scheduled Start At', 'start_at') !!}
{!! BootForm::text('Scheduled End At', 'end_at') !!}
{!! BootForm::select('Status', 'status')->options($statuses) !!}
{!! BootForm::select('Job Type', 'job_type_id')->options($jobTypes) !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
