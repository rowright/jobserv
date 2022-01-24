<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Worker;
use App\Models\WorkOrderWorker;
use App\Models\Status;
use App\Models\JobType;
use App\Models\Comments;
use App\Models\Customer;
use DB;
use Auth;
use Carbon;
use App\Library\Audit;

class SimpleController extends Controller
{
    public function quickAdd()
    {
        $jobTypes = JobType::Tenant()->whereNotNull('parent_id')->tree()->orderBy('name_path')->pluck('name_path', 'id')->toArray();
        return view('app.simple.quickadd', compact('jobTypes'));
    }
    public function quickAddStore(Request $request)
    {

        $jobType = JobType::find($request->job_type_id);
        $customer = new Customer;
        $customer->email = $request->email;
        $customer->phone1 = $request->phone1;
        $customer->phone2 = $request->phone2;
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->address1 = $request->address1;
        $customer->address2 = $request->address2;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->postcode = $request->postcode;
        $customer->source = $request->source;
        $customer->tenant_id = auth()->user()->tenant_id;
        $customer->save();

        $workOrder = new WorkOrder;
        $workOrder->address1 = $request->address1;
        $workOrder->address2 = $request->address2;
        $workOrder->name = $jobType->name. ' for '.$request->firstname.' '.$request->lastname;
        $workOrder->city = $request->city;
        $workOrder->state = $request->state;
        $workOrder->postcode = $request->postcode;
        $start = Carbon::parse($request->start_at);
        $end = Carbon::parse($request->end_at);
        $workOrder->start_at = $start->toDateTimeString();
        $workOrder->end_at = $end->toDateTimeString();
        $workOrder->status = 'New';
        $workOrder->job_type_id = $request->job_type_id;
        $workOrder->customer_id = $customer->id;
        $workOrder->tenant_id = auth()->user()->tenant_id;

        $workOrder->save();
        return redirect('/workorders/'.$workOrder->id);
    }
}
