<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;


class UnitController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $units = Unit::all();
        return view('admin.units.index', compact('units'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.units.create');
    }

    public function store(UnitRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Unit::create($data);
        return redirect(route('admin.units.index'))->with('success', __('Create Units successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $unit = Unit::find($id);
        if ($unit) {
            return view('admin.units.edit', compact('units'));
        } else {
            abort(404);
        }
    }

    public function update(UnitRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Unit::where('id', $id)->update($data);
        return redirect(route('admin.units.index'))->with('success', __('Update Unit successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $unit = Unit::find($request->input('id'));
        if ($unit) {
            $unit->delete();
            return redirect(route('admin.units.index'))->with('success', __('Delete Units successfully!'));
        } else {
            return redirect(route('admin.units.index'))->with('info', __('Units not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $unit = Unit::find($id);
        if ($unit) {
            return view('admin.units.view', compact('units'));
        } else {
            abort(404);
        }
    }
}
