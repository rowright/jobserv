<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Worker;
use App\Models\User;
use Crypt;

class iCalController extends Controller
{
    public function index()
    {
        $workers = Worker::Tenant()->Active()->get();
        return view('app.ical.index', compact('workers'));
    }
    public function worker($worker_id, $id)
    {
        $user = User::Tenant()->where('id', Crypt::decryptString($id))->firstOrFail();
        $events = WorkOrder::Tenant()->whereHas('Worker', function($q) use ($worker_id){
            $q->where('worker_id', '=', $id);
        })->get();
        define('ICAL_FORMAT', 'Ymd\THis\Z');
 
        $icalObject = "BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
URL:http://jobserv.blockte.ch/ical/".$id."
NAME:JobServ - Personal Calendar
PRODID:-//JobServ//Work Orders for User//EN\n";
       
        // loop over events
        foreach ($events as $event) {
            $icalObject .=
"BEGIN:VEVENT
DTSTART:" . date(ICAL_FORMAT, strtotime($event->start_at)) . "
DTEND:" . date(ICAL_FORMAT, strtotime($event->end_at)) . "
DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
SUMMARY:#".$event->id." ".$event->name." (".$event->JobType->name.")
UID:$event->id
STATUS: CONFIRMED
LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
LOCATION:".$event->address1." ".$event->address2." ".$event->city.", ".$event->state." ".$event->postcode."
END:VEVENT\n";
        }
 
        // close calendar
        $icalObject .= "END:VCALENDAR";
 
        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');
       
        //$icalObject = str_replace(' ', '', $icalObject);
   
        return $icalObject;
    }

    public function all($user_id)
    {
        $user = User::Tenant()->where('id', Crypt::decryptString($user_id))->firstOrFail();
        $events = WorkOrder::Tenant()->get();
        define('ICAL_FORMAT', 'Ymd\THis\Z');
 
        $icalObject = "BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
URL:http://jobserv.blockte.ch/ical/all
NAME:JobServ - Master Calendar
PRODID:-//JobServ//Work Orders//EN\n";
       
        // loop over events
        foreach ($events as $event) {
            $icalObject .=
"BEGIN:VEVENT
DTSTART:" . date(ICAL_FORMAT, strtotime($event->start_at)) . "
DTEND:" . date(ICAL_FORMAT, strtotime($event->end_at)) . "
DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
SUMMARY:#".$event->id." ".$event->name." (".$event->JobType->name.")
UID:$event->id
STATUS: CONFIRMED
LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
LOCATION:".$event->address1." ".$event->address2." ".$event->city."\, ".$event->state." ".$event->postcode."
END:VEVENT\n";
        }
 
        // close calendar
        $icalObject .= "END:VCALENDAR";
 
        // Set the headers
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');
       
        //$icalObject = str_replace(' ', '', $icalObject);
   
        return $icalObject;
        
    }
 
}
