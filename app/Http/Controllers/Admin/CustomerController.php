<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    } 

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        return view('admin.customers.create');
    }

    public function store(CustomerRequest $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Customer::create($data);
        return redirect(route('admin.customers.index'))->with('success', __('Create Customer successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $customer = Customer::find($id);
        if ($customer) {
            return view('admin.customers.edit', compact('customer'));
        } else {
            abort(404);
        }
    }

    public function update(CustomerRequest $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Customer::where('id', $id)->update($data);
        return redirect(route('admin.customers.index'))->with('success', __('Update customer successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $customer = Customer::find($request->input('customer_id'));
        if ($customer) {
            $customer->delete();
            return redirect(route('admin.customers.index'))->with('success', __('Delete customer successfully!'));
        } else {
            return redirect(route('admin.customers.index'))->with('info', __('customer not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $customer = Customer::find($id);
        if ($customer) {
            return view('admin.customers.view', compact('customer'));
        } else {
            abort(404);
        }
    }

    public function import(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        try {
            Excel::import(new CustomerImport, $request->file);
        } catch(\Illuminate\Database\QueryException $e) {
            return redirect(route('admin.customers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        } catch(\ErrorException $e) {
            return redirect(route('admin.customers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        }
        return redirect(route('admin.customers.index'))->with('success', __('Record are imported successfully!'));
    }
}
