@extends('app.layout.app')
@section('title')
New Job Type
@endsection
@section('buttons')
<a href="/jobtypes" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Job Type', 'name') !!}
{!! BootForm::select('Parent', 'parent_id')->options($jobTypes) !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
