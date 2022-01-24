@extends('app.layout.app')
@section('title')
Work Order Details - #{{ $workOrder->id }}
@endsection
@section('buttons')
<a href="/workorders/{{ $workOrder->id }}/print" class="btn btn-primary" rel="_blank" role="button">Print</a>
@if($workOrder->is_archived == 0)
<a href="/workorders/{{ $workOrder->id }}/edit" class="btn btn-warning" role="button">Edit</a>
<a href="/workorders/{{ $workOrder->id }}/archive" class="btn btn-danger" role="button">Archive</a>
@else
<a href="/workorders/{{ $workOrder->id }}/unarchive" class="btn btn-danger" role="button">Unarchive</a>
@endif
@endsection

@section('body')
<div class="row">
<div class="col-sm-6">
    <div class="card">
    <div class="card-header">
    Customer
            </div>

        <div class="card-body">
        <h5 class="card-title"><a href="/customers/{{$workOrder->customer_id}}">{{ $workOrder->Customer->firstname }} {{ $workOrder->Customer->lastname }} @if($workOrder->Customer->companyname) ({{$workOrder->Customer->companyname}}) @endif</a></h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $workOrder->Customer->email }}</h6>
        <a href="https://maps.apple.com/?daddr={{ $workOrder->Customer->address1 }} {{ $workOrder->Customer->address2 }} {{ $workOrder->Customer->city }}, {{ $workOrder->Customer->state }} {{ $workOrder->Customer->postcode }}">{{ $workOrder->Customer->address1 }}<br/>
            @if($workOrder->Customer->address2)
            {{ $workOrder->Customer->address2 }}<br/>
            @endif
            {{ $workOrder->Customer->city }}, {{ $workOrder->Customer->state }} {{ $workOrder->Customer->postcode }}</a><br/>
            <a href="tel:{{ $workOrder->Customer->phone1 }}">{{ $workOrder->Customer->phone1 }}</a><br/>
            <a href="tel:{{ $workOrder->Customer->phone2 }}">{{ $workOrder->Customer->phone2 }}</a>
        </div>
    </div>
    </div>

<div class="col-sm-6">
    <div class="card mb-2">
    <div class="card-header">
    Work Order
            </div>


        <div class="card-body">
        <h5 class="card-title">{{ $workOrder->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $workOrder->JobType->name }} - {{ $workOrder->status }}</h6>
            <a href="https://maps.apple.com/?daddr={{ $workOrder->address1 }} {{ $workOrder->address2 }} {{ $workOrder->city }}, {{ $workOrder->state }} {{ $workOrder->postcode }}">{{ $workOrder->address1 }}<br/>
            @if($workOrder->address2)
            {{ $workOrder->address2 }}<br/>
            @endif
            {{ $workOrder->city }}, {{ $workOrder->state }} {{ $workOrder->postcode }}</a><br/>

            </div>
        </div>
    </div>

    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Scheduling
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-6 text-center"><b>Scheduled Start</b></div>
                <div class="col-6 text-center"><b>Scheduled End</b></div>
            </div>
            <div class="row">
                <div class="col-6 text-center">{{ Carbon::parse($workOrder->start_at)->format('l F d, Y') }}</div>
                <div class="col-6 text-center">{{ Carbon::parse($workOrder->end_at)->format('l F d, Y') }}</div>
            </div>
            <div class="row">
                <div class="col-6 text-center">{{ Carbon::parse($workOrder->start_at)->format('h:i A') }}</div>
                <div class="col-6 text-center">{{ Carbon::parse($workOrder->end_at)->format('h:i A') }}</div>
            </div>
            @if($overlaps->count() > 0)
            <br/>
            <div class="alert alert-danger">This job has overlapping schedules for the workers. Click on the link below to go to that job.</div>
            <ul>
                @foreach($overlaps as $overlap)
                <li><a href="/workorders/{{$overlap->job_id}}">{{ $overlap->job_name }} (#{{$overlap->job_id}}) - {{ $overlap->worker}} @if($overlap->team)- {{ $overlap->team }}@endif</a></li>
                @endforeach
            </ul>
            @endif
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
            Workers
            </div>
            <div class="card-body">
                <ul>
                    @forelse($workOrder->Worker->sortBy('team') as $worker)
                        <li>{{ $worker->displayname }} <a href="/workorders/{{$workOrder->id}}/removeworker/{{$worker->id}}">(remove)</a> @if($worker->team)- {{ $worker->team }}@endif</li>
                    @empty
                        <li>No workers are assigned to this job.</li>
                    @endforelse
                </ul>
                @if($workers->count() > 0)
                <form method="POST" action="/workorders/{{$workOrder->id}}/addworker">
                @csrf
                    <select name="worker_id" class="form-control" onchange="this.form.submit()">
                        <option value="-">Add New Worker</option>
                        @foreach($workers as $worker)
                        <option value="{{ $worker->id }}">{{ $worker->displayname }} @if($worker->team)- {{ $worker->team }}@endif</option>
                        @endforeach
                    </select>
                </form>
                @elseif($workers->count() == 0 && $workOrder->Worker->count() == 0)
                <div class="alert alert-danger">There are no available workers for this job.</div>
                @endif
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
            Related Work Orders
            </div>
            <div class="card-body">
                @if($workOrder->parent_id == 0 or !$workOrder->parent_id)
                <p>There is no parent work order. To assign a parent work order, enter it's number below.</p>
                <form method="POST" action="/workorders/{{$workOrder->id}}/link">
                @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="parent_id" class="form-control"></input>
                        <div class="input-group-append">
                            <input type="submit" class="btn btn-outline-secondary" role="button" value="Link">
                        </div>
                    </div>
                </form>
                @else
                This work order is a child of: <a href="/workorders/{{$workOrder->Parent->id}}">{{ $workOrder->Parent->name }} (#{{$workOrder->Parent->id}})</a> <a href="/workorders/{{$workOrder->id}}/unlink">(remove)</a>
                @endif
                @if($children->count() > 0)
                <br/><hr/>
                The following work orders are children of this work order.
                <ul>
                @foreach($children as $child)
                    <li><a href="/workorders/{{ $child->id }}">{{ $child->name }} (#{{ $child->id}}) @if($child->work_order_path !== $child->name)({{ $child->work_order_path }})@endif</a></li>
                @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8 mt-2">
        <h5>Notes</h5>
        <form action="/workorders/{{$workOrder->id}}/addcomment" method="POST" class="mb-3">
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Add New Comment</label>
            <textarea class="form-control" name="body" rows="3"></textarea>
            </div>
            <input type="submit" role="button" class="btn btn-primary" value="Add">
            @csrf
        </form>
        @foreach($workOrder->comments->whereNull('technical')->sortByDesc('created_at') as $comment)
        <div class="card mb-2">
            <div class="card-header">
                {{ $comment->name }} <span class="text-muted">{{ $comment->user->name ?? 'System Action' }} @ ({{ $comment->created_at }}) </span>
            </div>
            <div class="card-body">
                <span title="{{$comment->technical}}">{{ $comment->body }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
