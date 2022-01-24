@extends('app.layout.app')
@section('title')
Quick Add
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::select('Job Type', 'job_type_id')->options($jobTypes) !!}

{!! BootForm::text('First Name', 'firstname') !!}
{!! BootForm::text('Last Name', 'lastname') !!}
{!! BootForm::email('Email', 'email') !!}
{!! BootForm::text('Phone 1', 'phone1') !!}
{!! BootForm::text('Phone 2', 'phone2') !!}
{!! BootForm::text('Address 1', 'address1') !!}
{!! BootForm::text('Address 2', 'address2') !!}
{!! BootForm::text('City', 'city') !!}
{!! BootForm::text('State', 'state') !!}
{!! BootForm::text('Zip Code', 'postcode') !!}

{!! BootForm::text('Scheduled Start At', 'start_at') !!}
{!! BootForm::text('Scheduled End At', 'end_at') !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection