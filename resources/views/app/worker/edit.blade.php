@extends('app.layout.app')
@section('title')
Worker Details - {{ $worker->displayname }}
@endsection
@section('buttons')
<a href="/workers" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('First Name', 'firstname', $worker->firstname) !!}
{!! BootForm::text('Last Name', 'lastname', $worker->lastname) !!}
{!! BootForm::email('Email', 'email', $worker->email) !!}
{!! BootForm::text('Phone', 'phone', $worker->phone) !!}
{!! BootForm::text('Team', 'team', $worker->team) !!}
{!! BootForm::text('Display Name', 'displayname', $worker->displayname) !!}
{!! BootForm::select('Status', 'is_active')->options([0=>'No', 1=>'Yes'])->select($worker->is_active) !!}
{!! BootForm::select('User Account', 'user_id')->options($users)->select($user_id) !!}

<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
