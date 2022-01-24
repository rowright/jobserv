<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobType;

class JobTypeController extends Controller
{
    public function index()
    {
        $jobTypes = JobType::Tenant()->whereNotNull('parent_id')->tree()->get();
        return view('app.jobtype.index', compact('jobTypes'));
    }
    public function new()
    {
        $jobTypes = JobType::Tenant()->tree()->orderBy('name_path')->pluck('name_path', 'id')->toArray();
        return view('app.jobtype.new', compact('jobTypes'));
    }
    public function edit($id)
    {
        $jobTypes = JobType::Tenant()->where('id', '<>', $id)->tree()->orderBy('name_path')->pluck('name_path', 'id')->toArray();
        $jobType = JobType::findOrFail($id);
        return view('app.jobtype.edit', compact('jobTypes', 'jobType'));
    }
    public function update(Request $request, $id)
    {
        $jobType = JobType::Tenant()->findOrFail($id);
        $jobType->parent_id = $request->parent_id;
        $jobType->name = $request->name;
        $jobType->save();
        return redirect('/jobtypes/'.$id);
    }
    public function store(Request $request)
    {
        $jobType = new JobType;
        $jobType->parent_id = $request->parent_id;
        $jobType->name = $request->name;
        $jobType->tenant_id = auth()->user()->tenant_id;
        $jobType->save();
        return redirect('/jobtypes');
    }

}