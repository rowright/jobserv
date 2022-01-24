<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Hash;
use Auth;

class UserController extends Controller
{
    public function index() 
    {
        $users = User::Tenant()->with(['Worker', 'Customer'])->get();
        return view('app.user.index', compact('users'));
    }
    public function edit($id) 
    {
        $user = User::Tenant()->findOrFail($id);
        return view('app.user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::Tenant()->findOrFail($id);
        $user->email = $request->email;
        $user->name = $request->name;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect('/users/'.$id);
    }
    public function delete($id)
    {
        $user = User::Tenant()->findOrFail($id);
        if(Auth::user()->id !== $user->id) {
            $user->delete();
        }
        return redirect('/users');
    }
    public function create() 
    {
        return view('app.user.new');
    }
    public function save(Request $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->tenant_id = auth()->user()->tenant_id;
        $user->save();
        return redirect('/users');
    }

}
