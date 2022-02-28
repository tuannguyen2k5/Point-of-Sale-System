<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class QuotationController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $quotations = Quotation::paginate();
        return view('admin.quotations.index', compact('quotations'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.quotations.create');
    }

    public function store(QuotationRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $data['month'] = Carbon::createFromFormat('d/m/Y', $request->month)->format('Y-m-d');
        Quotation::create($data);
        return redirect(route('admin.quotations.index'))->with('success', __('Create Quotation successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $quotation = Quotation::find($id);
        if ($quotation) {
            return view('admin.quotations.edit', compact('quotation'));
        } else {
            abort(404);
        }
    }

    public function update(QuotationRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        $data['month'] = Carbon::createFromFormat('d/m/Y', $request->month)->format('Y-m-d');
        Quotation::where('id', $id)->update($data);
        return redirect(route('admin.quotations.index'))->with('success', __('Update Quotation successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $quotation = Quotation::find($request->input('quotation_id'));
        if ($quotation) {
            $quotation->delete();
            return redirect(route('admin.quotations.index'))->with('success', __('Delete Quotation successfully!'));
        } else {
            return redirect(route('admin.quotations.index'))->with('info', __('Quotation not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $quotation = Quotation::find($id);
        if ($quotation) {
            return view('admin.quotations.view', compact('quotation'));
        } else {
            abort(404);
        }
    }
}
