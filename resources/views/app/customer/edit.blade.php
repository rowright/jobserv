@extends('app.layout.app')
@section('title')
Customer Details - {{ $customer->firstname }} {{ $customer->lastname }}
@endsection
@section('buttons')
<a href="/customers" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('First Name', 'firstname', $customer->firstname) !!}
{!! BootForm::text('Last Name', 'lastname', $customer->lastname) !!}
{!! BootForm::email('Email', 'email', $customer->email) !!}
{!! BootForm::text('Phone 1', 'phone1', $customer->phone1) !!}
{!! BootForm::text('Phone 2', 'phone2', $customer->phone2) !!}
{!! BootForm::text('Address 1', 'address1', $customer->address1) !!}
{!! BootForm::text('Address 2', 'address2', $customer->address2) !!}
{!! BootForm::text('City', 'city', $customer->city) !!}
{!! BootForm::text('State', 'state', $customer->state) !!}
{!! BootForm::text('Zip Code', 'postcode', $customer->postcode) !!}
{!! BootForm::text('Company Name', 'companyname', $customer->companyname) !!}
{!! BootForm::text('Source', 'source', $customer->source) !!}

<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
