@extends('app.layout.app')
@section('title')
New User
@endsection
@section('buttons')
<a href="/users" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Name', 'name') !!}
{!! BootForm::email('Email', 'email') !!}
{!! BootForm::password('Password', 'password') !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
