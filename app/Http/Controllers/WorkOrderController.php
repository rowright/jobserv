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

class WorkOrderController extends Controller
{
    public function index() 
    {
        $workOrders = WorkOrder::Tenant()->where('is_archived',0)->with(['JobType', 'Customer'])->get();
        return view('app.workorder.index', compact('workOrders'));
    }
    public function all() 
    {
        $workOrders = WorkOrder::Tenant()->with(['JobType', 'Customer'])->get();
        return view('app.workorder.index', compact('workOrders'));
    }
    public function create($id) 
    {
        $customer = Customer::findOrFail($id);
        $jobTypes = JobType::tree()->orderBy('name_path')->pluck('name_path', 'id')->toArray();
        $statuses = Status::where('type', 'WorkOrder')->where('is_available', 1)->pluck('name', 'name')->toArray();
        return view('app.workorder.new', compact('customer', 'statuses', 'jobTypes'));
    }
    public function store(Request $request, $id) 
    {
        $workOrder = new WorkOrder;
        $workOrder->address1 = $request->address1;
        $workOrder->address2 = $request->address2;
        $workOrder->name = $request->name;
        $workOrder->city = $request->city;
        $workOrder->state = $request->state;
        $workOrder->postcode = $request->postcode;
        $start = Carbon::parse($request->start_at);
        $end = Carbon::parse($request->end_at);
        $workOrder->start_at = $start->toDateTimeString();
        $workOrder->end_at = $end->toDateTimeString();
        $workOrder->status = $request->status;
        $workOrder->job_type_id = $request->job_type_id;
        $workOrder->customer_id = $id;
        $workOrder->tenant_id = auth()->user()->tenant_id;
        $workOrder->save();
        return redirect('/workorders/'.$workOrder->id);
    }
    public function show($id) 
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id)->load(['JobType', 'Customer', 'Worker', 'Parent', 'Comments']);
        $overlaps = DB::table('work_orders as w1')
        ->select('ww1.worker_id', 'w2.id AS job_id', 'w2.name AS job_name', 'w2.start_at', 'w2.end_at', 'w.displayname AS worker', 'w.team')
        ->join('work_order_workers as ww1', 'ww1.work_order_id', '=', 'w1.id')
        ->join('work_orders as w2', function ($join) {
            $join->on('w1.start_at', '>=', 'w2.start_at')
                ->on('w1.end_at', '>=', 'w2.start_at')
                ->orOn('w1.start_at', '<=', 'w2.end_at')
                ->on('w1.end_at', '<=', 'w2.end_at');
        })
        ->join('work_order_workers as ww2', function ($join) {
            $join->on( 'ww2.work_order_id', '=', 'w2.id')
                ->on('ww2.worker_id', '=', 'ww1.worker_id')
                ->on('ww1.work_order_id', '<>', 'ww2.work_order_id');
        })
        ->join('workers as w', 'w.id', '=', 'ww1.worker_id')
        ->where('w1.id', '=', -1)
        //->where('w1.id', '=', $workOrder->id)
        ->orderBy('w.id')
        ->get();
        $workers = Worker::Tenant()->Active()->whereNotIn('id', function($query) use ($workOrder) {
                $query->select('worker_id')->from('work_order_workers')->where('work_order_id', '=', $workOrder->id);
        })->orderBy('team')->get();
        $children = $workOrder->descendants()->get();
        return view('app.workorder.show', compact('workOrder', 'overlaps', 'workers', 'children'));
    }    
    public function print($id) 
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id)->load(['JobType', 'Customer', 'Worker', 'Parent', 'Comments']);
        $children = $workOrder->descendants()->get();
        return view('app.workorder.print', compact('workOrder', 'children'));
    }
    public function edit($id) 
    {
        $jobTypes = JobType::whereNotNull('parent_id')->tree()->orderBy('name_path')->pluck('name_path', 'id')->toArray();
        $workOrder = WorkOrder::Tenant()->findOrFail($id)->load(['JobType']);
        $statuses = Status::where('type', 'WorkOrder')->where('is_available', 1)->pluck('name', 'name')->toArray();
        return view('app.workorder.edit', compact('workOrder', 'statuses', 'jobTypes'));
    }
    public function save(Request $request, $id) 
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $original = $workOrder->getOriginal();
        $workOrder->address1 = $request->address1;
        $workOrder->address2 = $request->address2;
        $workOrder->name = $request->name;
        $workOrder->city = $request->city;
        $workOrder->state = $request->state;
        $workOrder->postcode = $request->postcode;
        $start = Carbon::parse($request->start_at);
        $end = Carbon::parse($request->end_at);
        $workOrder->start_at = $start->toDateTimeString();
        $workOrder->end_at = $end->toDateTimeString();
        $workOrder->status = $request->status;
        $workOrder->job_type_id = $request->job_type_id;
        $workOrder->save();
        $changes = $workOrder->getChanges();
        Audit::audit('App\Models\WorkOrder', $id, 'The work order was edited. Please see technical details.', 'Update work order', json_encode($original).PHP_EOL.PHP_EOL.json_encode($changes));             
        return redirect('/workorders/'.$id);
    }

    public function archive($id)
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $workOrder->is_archived = 1;
        $workOrder->save();
        return redirect('/workorders');
    }
    public function unarchive($id)
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $workOrder->is_archived = 0;
        $workOrder->save();
        return redirect('/workorders/'.$id);
    }
    public function link(Request $request, $id)
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $workOrderParent = WorkOrder::Tenant()->findOrFail($request->parent_id);
        $workOrder->parent_id = $workOrderParent->id;
        $workOrder->save();
        Audit::audit('App\Models\WorkOrder', $id, 'Linked work order to parent '.$workOrderParent->id.'.', 'Added parent relationship', $workOrderParent->id);             
        return redirect('/workorders/'.$id);
    }
    public function unlink($id)
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $oldParent = $workOrder->parent_id;
        $workOrder->parent_id = 0;
        $workOrder->save();
        Audit::audit('App\Models\WorkOrder', $id, 'Unlinked work order from parent '.$oldParent.'.', 'Removed parent relationship', $oldParent);             
        return redirect('/workorders/'.$id);
    }

    public function addWorker(Request $request, $id)
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $workOrderWorker = new WorkOrderWorker;
        $workOrderWorker->work_order_id = $id;
        $workOrderWorker->worker_id = $request->worker_id;
        $workOrderWorker->save();
        $worker = Worker::find($request->worker_id);
        Audit::audit('App\Models\WorkOrder', $id, 'Associated '.$worker->displayname.' to work order.', 'Added worker', $request->worker_id);             
        return redirect('/workorders/'.$id);
    }
    public function removeWorker(Request $request, $id, $worker_id)
    {
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $workOrderWorker = WorkOrderWorker::where('work_order_id', $id)->where('worker_id', $worker_id)->first();
        $workOrderWorker->delete();
        $worker = Worker::find($worker_id);
        Audit::audit('App\Models\WorkOrder', $id, 'Unassociated '.$worker->displayname.' to work order.', 'Removed worker', $worker_id);             
        return redirect('/workorders/'.$id);
    }
    public function comment(Request $request, $id)
    {
        $request->validate([
            'body' => 'bail|required',
        ]);
        
        $workOrder = WorkOrder::Tenant()->findOrFail($id);
        $comment = new Comments;
        $comment->name = 'User added comment';
        $comment->body = $request->body;
        $comment->user_id = Auth::user()->id;
        $comment->commentable_id = $id;
        $comment->commentable_type = 'App\Models\WorkOrder';
        $comment->tenant_id = auth()->user()->tenant_id;
        $comment->save();
        return redirect('/workorders/'.$id);
    }

}
