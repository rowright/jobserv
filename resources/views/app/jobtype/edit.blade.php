@extends('app.layout.app')
@section('title')
Edit Job Type
@endsection
@section('buttons')
<a href="/jobtypes" class="btn btn-primary" role="button">Go back</a>
@endsection

@section('body')
{!! BootForm::open() !!}
{!! BootForm::text('Job Type', 'name', $jobType->name) !!}
{!! BootForm::select('Parent', 'parent_id')->options($jobTypes)->select($jobType->parent_id) !!}
<input type="submit" value="Save" class="btn btn-primary" role="button" />
{!! BootForm::close() !!}

@endsection
