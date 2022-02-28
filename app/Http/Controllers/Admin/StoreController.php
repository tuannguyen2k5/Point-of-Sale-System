<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Warehouse;
use App\Models\User;
use App\Http\Requests\StoreRequest;

class StoreController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $stores = Store::all();
        foreach ($stores as $store) {
            $warehouse = Warehouse::find($store->warehouse_id);
            $store->warehouse = $warehouse->name;

            $manager = User::find($store->manager_id);
            $store->manager = $manager->name;
        }
        return view('admin.stores.index', compact('stores'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $warehouses = Warehouse::select('id', 'name')->get();
        $managers = User::select('id', 'name')->get();

        return view('admin.stores.create', compact(['warehouses', 'managers']));
    }

    public function store(StoreRequest $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Store::create($data);
        return redirect(route('admin.stores.index'))->with('success', __('Create Store successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $store = Store::find($id);
        if ($store) {
            $warehouses = Warehouse::select('id', 'name')->get();
            $managers = User::select('id', 'name')->get();
            return view('admin.stores.edit', compact(['store', 'warehouses', 'managers']));
        } else {
            abort(404);
        }
    }
    public function update(StoreRequest $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        store::where('id', $id)->update($data);
        return redirect(route('admin.stores.index'))->with('success', __('Update store successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $store = store::find($request->input('store_id'));
        if ($store) {
            $store->delete();
            return redirect(route('admin.stores.index'))->with('success', __('Delete store successfully!'));
        } else {
            return redirect(route('admin.stores.index'))->with('info', __('store not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
        $store = store::find($id);
        if ($store) {
            $warehouse = Warehouse::find($store->warehouse_id);
            $store->warehouse = $warehouse->name;

            $manager = User::find($store->manager_id);
            $store->manager = $manager->name;
            return view('admin.stores.view', compact('store'));
        } else {
            abort(404);
        }
    }
}
