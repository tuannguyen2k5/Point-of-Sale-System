<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $warehouses = Warehouse::all();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.warehouses.create');
    }

    public function store(WarehouseRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Warehouse::create($data);
        return redirect(route('admin.warehouses.index'))->with('success', __('Create Warehouse successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $warehouse = Warehouse::find($id);
        if ($warehouse) {
            return view('admin.warehouses.edit', compact('warehouse'));
        } else {
            abort(404);
        }
    }

    public function update(WarehouseRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Warehouse::where('id', $id)->update($data);
        return redirect(route('admin.warehouses.index'))->with('success', __('Update Warehouse successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $warehouse = Warehouse::find($request->input('warehouse_id'));
        if ($warehouse) {
            $warehouse->delete();
            return redirect(route('admin.warehouses.index'))->with('success', __('Delete Warehouse successfully!'));
        } else {
            return redirect(route('admin.warehouses.index'))->with('info', __('Warehouse not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $warehouse = Warehouse::find($id);
        if ($warehouse) {
            $products = Product::select('id', 'name')->get();
            $product_list = DB::table('product_of_warehouses')->where('warehouse_id', $id)->get();
            return view('admin.warehouses.view', compact(['warehouse', 'product_list', 'products']));
        } else {
            abort(404);
        }
    }
}
