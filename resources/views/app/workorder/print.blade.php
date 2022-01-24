<html>
    <head>
</head>
    <body>
    <h2>Work Order - #{{ $workOrder->id }} - {{ $workOrder->name }} (Job Type: {{ $workOrder->JobType->name }})</h2>
    <p><b>Property Address:</b><br/>
        {{ $workOrder->address1 }}<br/>
        @if($workOrder->address2)
        {{ $workOrder->address2 }}<br/>
        @endif
        {{ $workOrder->city }}, {{ $workOrder->state }} {{ $workOrder->postcode }}</p>

    <p><b>Customer Details:</b><br/>{{ $workOrder->Customer->firstname }} {{ $workOrder->Customer->lastname }} @if($workOrder->Customer->companyname) ({{$workOrder->Customer->companyname}}) @endif<br/>
            {{ $workOrder->Customer->address1 }}<br/>
            @if($workOrder->Customer->address2)
            {{ $workOrder->Customer->address2 }}<br/>
            @endif
            {{ $workOrder->Customer->city }}, {{ $workOrder->Customer->state }} {{ $workOrder->Customer->postcode }}<br/>
            {{ $workOrder->Customer->phone1 }}<br/>
            {{ $workOrder->Customer->phone2 }}<br/>
            {{ $workOrder->Customer->email }}</p>
                <p><b>Scheduled Start</b>: {{ Carbon::parse($workOrder->start_at)->format('l F d, Y h:i A') }}</p>
                <p><b>Scheduled End</b>: {{ Carbon::parse($workOrder->end_at)->format('l F d, Y h:i A') }}</p>
            <p><b>Workers</b></p>
                <ul>
                    @forelse($workOrder->Worker->sortBy('team') as $worker)
                        <li>{{ $worker->displayname }} @if($worker->team)- {{ $worker->team }}@endif</li>
                    @empty
                        <li>No workers are assigned to this job.</li>
                    @endforelse
                </ul>
            <p><b>Related Work Orders</b></p>
                @if($workOrder->parent_id == 0 or !$workOrder->parent_id)
                <p>There is no parent work order.</p>
                @else
                <p>This work order is a child of: {{ $workOrder->Parent->name }} (#{{$workOrder->Parent->id}})</p>
                @endif
                @if($children->count() > 0)
                <hr/>
                <p>The following work orders are children of this work order.</p>
                <ul>
                @foreach($children as $child)
                    <li>{{ $child->name }} (#{{ $child->id}}) @if($child->work_order_path !== $child->name)({{ $child->work_order_path }})@endif</li>
                @endforeach
                </ul>
                @endif
        <p><b>Notes</b></p>
        @foreach($workOrder->comments->whereNull('technical')->sortByDesc('created_at') as $comment)
        <p>{{ $comment->name }} - {{ $comment->user->name ?? 'System Action' }} @ ({{ $comment->created_at }})</p>
        <p>{{ $comment->body }}</p>
        <hr/>
        @endforeach
</body>
</html>