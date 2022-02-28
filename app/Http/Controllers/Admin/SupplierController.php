<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use App\Imports\SupplierImport;
use Excel;

class SupplierController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        return view('admin.suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Supplier::create($data);
        return redirect(route('admin.suppliers.index'))->with('success', __('Create Supplier successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $supplier = Supplier::find($id);
        if ($supplier) {
            return view('admin.suppliers.edit', compact('supplier'));
        } else {
            abort(404);
        }
    }
    public function update(SupplierRequest $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Supplier::where('id', $id)->update($data);
        return redirect(route('admin.suppliers.index'))->with('success', __('Update supplier successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $supplier = Supplier::find($request->input('supplier_id'));
        if ($supplier) {
            $supplier->delete();
            return redirect(route('admin.suppliers.index'))->with('success', __('Delete supplier successfully!'));
        } else {
            return redirect(route('admin.suppliers.index'))->with('info', __('supplier not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $supplier = Supplier::find($id);
        if ($supplier) {
            return view('admin.suppliers.view', compact('supplier'));
        } else {
            abort(404);
        }
    }

    public function import(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        try {
            Excel::import(new SupplierImport, $request->file);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect(route('admin.suppliers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        } catch (\ErrorException $e) {
            return redirect(route('admin.suppliers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        }
        return redirect(route('admin.suppliers.index'))->with('success', __('Record are imported successfully!'));
    }
}
