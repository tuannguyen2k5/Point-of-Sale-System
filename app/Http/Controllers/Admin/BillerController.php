<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biller;
use App\Models\Store;
use App\Http\Requests\BillerRequest;
use App\Imports\BillerImport;
use Excel;

class BillerController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $billers = Biller::all();
        foreach ($billers as $biller) {
            $store = Store::find($biller->store_id);
            $biller->store = $store->name;
        }
        return view('admin.billers.index', compact('billers'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $stores = Store::select('id', 'name')->get();
        return view('admin.billers.create', compact('stores'));
    }

    public function store(BillerRequest $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Biller::create($data);
        return redirect(route('admin.billers.index'))->with('success', __('Create biller successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $biller = Biller::find($id);
        $stores = Store::select('id', 'name')->get();
        if ($biller) {
            return view('admin.billers.edit', compact(['biller', 'stores']));
        } else {
            abort(404);
        }
    }
    public function update(BillerRequest $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Biller::where('id', $id)->update($data);
        return redirect(route('admin.billers.index'))->with('success', __('Update biller successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $biller = Biller::find($request->input('biller_id'));
        if ($biller) {
            $biller->delete();
            return redirect(route('admin.billers.index'))->with('success', __('Delete biller successfully!'));
        } else {
            return redirect(route('admin.billers.index'))->with('info', __('biller not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $biller = Biller::find($id);
        $store = Store::find($biller->store_id);
        $biller->store = $store->name;
        if ($biller) {
            return view('admin.billers.view', compact('biller'));
        } else {
            abort(404);
        }
    }

    public function import(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        try {
            Excel::import(new BillerImport, $request->file);
        } catch(\Illuminate\Database\QueryException $e) {
            return redirect(route('admin.billers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        } catch(\ErrorException $e) {
            return redirect(route('admin.billers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        }
        return redirect(route('admin.billers.index'))->with('success', __('Record are imported successfully!'));
    }
}
