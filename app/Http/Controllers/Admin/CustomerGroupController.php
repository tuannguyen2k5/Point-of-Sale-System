<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerGroupRequest;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $customergroups = CustomerGroup::paginate();
        return view('admin.customergroups.index', compact('customergroups'));
    }
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.customergroups.create');
    }
    public function store(CustomerGroupRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        CustomerGroup::create($data);
        return redirect(route('admin.customergroups.index'))->with('success', __('Create Customer Group successfully!'));
    }
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $customergroup = CustomerGroup::find($id);
        if ($customergroup) {
            return view('admin.customergroups.edit', compact('customergroup'));
        } else {
            abort(404);
        }
    }
    public function update(CustomerGroupRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        CustomerGroup::where('id', $id)->update($data);
        return redirect(route('admin.customergroups.index'))->with('success', __('Update Customer Group successfully!'));
    }
    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $customergroup = CustomerGroup::find($request->input('customergroup_id'));
        if ($customergroup) {
            $customergroup->delete();
            return redirect(route('admin.customergroups.index'))->with('success', __('Delete customergroup successfully!'));
        } else {
            return redirect(route('admin.customergroups.index'))->with('info', __('Customer group not found!'));
        }
    }
    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $customergroup = CustomerGroup::find($id);
        if ($customergroup) {
            return view('admin.customergroups.view', compact('customergroup'));
        } else {
            abort(404);
        }
    }
}
