<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\User;

class WorkerController extends Controller
{
    public function index() 
    {
        $workers = Worker::Tenant()->get();
        return view('app.worker.index', compact('workers'));
    }
    public function edit($id) 
    {
        $worker = Worker::Tenant()->findOrFail($id);
        $users = User::Tenant()->get()->pluck('name', 'id')->toArray();
        $users[0] = 'No User Account';
        if(!$worker->user_id) { 
            $user_id = 0;
        } else {
            $user_id = $worker->user_id;
        } 
        
        return view('app.worker.edit', compact('worker', 'users', 'user_id'));
    }
    public function update(Request $request, $id)
    {
        $worker = Worker::Tenant()->findOrFail($id);
        $worker->email = $request->email;
        $worker->phone = $request->phone;
        $worker->firstname = $request->firstname;
        $worker->lastname = $request->lastname;
        $worker->team = $request->team;
        $worker->displayname = $request->displayname;
        $worker->user_id = $request->user_id;
        $worker->is_active = $request->is_active;
        $worker->save();
        return redirect('/workers');
    }
    public function delete($id)
    {
        $worker = Worker::Tenant()->findOrFail($id);
        if(Auth::user()->id !== $worker->id) {
            $worker->delete();
        }
        return redirect('/workers');
    }
    public function create() 
    {
        return view('app.worker.new');
    }
    public function save(Request $request)
    {
        $worker = new Worker;
        $worker->email = $request->email;
        $worker->phone = $request->phone;
        $worker->firstname = $request->firstname;
        $worker->lastname = $request->lastname;
        $worker->team = $request->team;
        $worker->is_active = 1;
        if(!$request->displayname) {
            $worker->displayname = $request->firstname;
        } else {
            $worker->displayname = $request->displayname;
        }
        $worker->user_id = $request->user_id;
        $worker->tenant_id = auth()->user()->tenant_id;
        $worker->save();
        return redirect('/workers');
    }
}
