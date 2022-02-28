<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaxRequest;
use App\Models\TaxRate;
use Illuminate\Http\Request;


class TaxController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $tax_rate = TaxRate::all();
        return view('admin.tax_rate.index', compact('tax_rate'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.tax_rate.create');
    }

    public function store(TaxRateRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        TaxRate::create($data);
        return redirect(route('admin.tax_rate.index'))->with('success', __('Create Tax_rate successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $tax = TaxRate::find($id);
        if ($tax) {
            return view('admin.tax_rate.edit', compact('tax_rate'));
        } else {
            abort(404);
        }
    }

    public function update(TaxRateRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        TaxRate::where('id', $id)->update($data);
        return redirect(route('admin.tax_rate.index'))->with('success', __('Update Tax_rate successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $tax = TaxRate::find($request->input('id'));
        if ($tax) {
            $tax->delete();
            return redirect(route('admin.tax_rate.index'))->with('success', __('Delete Tax_rate successfully!'));
        } else {
            return redirect(route('admin.tax_rate.index'))->with('info', __('Tax_rate not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $tax = TaxRate::find($id);
        if ($tax) {
            return view('admin.tax_rate.view', compact('tax_rate'));
        } else {
            abort(404);
        }
    }
}
