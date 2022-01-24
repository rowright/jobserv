@extends('app.layout.guest')
@section('title')
Create New Tenant
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Company Name', 'company') !!}
{!! BootForm::text('Name', 'name') !!}
{!! BootForm::email('Email', 'email') !!}
{!! BootForm::password('Password', 'password') !!}
<input type="submit" value="Create" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
