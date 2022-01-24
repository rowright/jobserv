@extends('app.layout.app')
@section('title')
iCalendar Links
@endsection

@section('body')
<ul>
    <li><a href="webcal://jobserv.blockte.ch/ical/all/{{Crypt::encryptString(Auth::user()->id)}}.ics">Calendar for all events</a></li>
    @foreach($workers as $worker)
    <li><a href="webcal://jobserv.blockte.ch/ical/{{$worker->id}}/{{Crypt::encryptString(Auth::user()->id)}}.ics">Calendar for {{ $worker->displayname }} - {{ $worker->team }}</a></li>
    @endforeach
</ul>
@endsection
