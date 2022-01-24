@extends('app.layout.app')
@section('title')
New Worker
@endsection
@section('buttons')
<a href="/workers" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Display Name', 'displayname') !!}
{!! BootForm::text('First Name', 'firstname') !!}
{!! BootForm::text('Last Name', 'lastname') !!}
{!! BootForm::email('Email', 'email') !!}
{!! BootForm::text('Phone', 'phone') !!}
{!! BootForm::text('Team', 'team') !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
