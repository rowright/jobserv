<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobType;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('app.admin.newtenant');
    }
    public function createTenant(Request $request)
    {

        $tenant_id = User::max('tenant_id') + 1;
        $jobType = new JobType;
        $jobType->name = $request->company;
        $jobType->tenant_id = $tenant_id;
        $jobType->save();

        $user = new User;
        $user->tenant_id = $tenant_id;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/')->withErrors(['Tenant '.$tenant_id.' was created.']);

    }
    public function registerTenant()
    {
        return view('app.admin.newtenant');
    }

    public function purgeTenant(Request $request)
    {

        $tenant_id = auth()->user()->tenant_id;

        \App\Models\User::where('tenant_id', $tenant_id)->delete();
        \App\Models\Comments::where('tenant_id', $tenant_id)->delete();
        \App\Models\JobType::where('tenant_id', $tenant_id)->delete();
        \App\Models\Customer::where('tenant_id', $tenant_id)->delete();
        \App\Models\Worker::where('tenant_id', $tenant_id)->delete();
        \App\Models\WorkOrder::where('tenant_id', $tenant_id)->delete();

        Auth::logout();

        return redirect('/')->withErrors(['Tenant '.$tenant_id.' was purged from the database.']);

    }
}
