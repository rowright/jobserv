<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index() 
    {
        $customers = Customer::Tenant()->get();
        return view('app.customer.index', compact('customers'));
    }
    public function edit($id) 
    {
        $customer = Customer::Tenant()->findOrFail($id);
        return view('app.customer.edit', compact('customer'));
    }
    public function show($id) 
    {
        $customer = Customer::Tenant()->with(['WorkOrder'])->findOrFail($id);
        return view('app.customer.show', compact('customer'));
    }
    public function update(Request $request, $id)
    {
        $customer = customer::Tenant()->findOrFail($id);
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
        $customer->companyname = $request->companyname;
        $customer->source = $request->source;
        $customer->save();
        return redirect('/customers/'.$id);
    }
    public function create() 
    {
        return view('app.customer.new');
    }
    public function save(Request $request)
    {
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
        $customer->companyname = $request->companyname;
        $customer->source = $request->source;
        $customer->tenant_id = auth()->user()->tenant_id;
        $customer->save();
        return redirect('/customers/'.$customer->id);
    }
}
