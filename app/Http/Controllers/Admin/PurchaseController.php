<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Http\Requests\PurchaseRequest;
use App\Imports\PurchaseImport;
use Excel;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchases = Purchase::all();
        foreach($purchases as $purchase) 
        {
            $supplier = Supplier::find($purchase->supplier_id);
            $product = Product::find($purchase->product_id);
            $warehouse = Warehouse::find($purchase->warehouse_id);

            $purchase->supplier = $supplier->name;
            $purchase->product = $product->name;
            $purchase->warehouse = $warehouse->name;
        }
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $warehouses = Warehouse::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        $suppliers = Supplier::select('id', 'name')->get();
        return view('admin.purchases.create', compact(['products', 'suppliers', 'warehouses']));
    }

    public function store(PurchaseRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $purchase = Purchase::create($data);

        $product = $this->getRecordWarehouse($data['warehouse_id'], $data['product_id']);
        if($product) 
        {
            $new_quantity = $product->quantity + $data['product_id'];  
            $this->saveRecordWarehouse($data['warehouse_id'], $data['product_id'], $new_quantity); 
        } else {
            $this->insertRecordWarehouse($data['warehouse_id'], $data['product_id'], $data['quantity']);
        }
        
        $payment = PurchasePayment::create(['payment_type_id' => 2]);
        Purchase::find($purchase->id)->update(['payment_id' => $payment->id]);

        return redirect(route('admin.purchases.index'))->with('success', __('Create purchase successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchase = Purchase::find($id);
        $warehouses = Warehouse::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        $suppliers = Supplier::select('id', 'name')->get();

        if ($purchase) {
            return view('admin.purchases.edit', compact(['purchase', 'products', 'suppliers', 'warehouses']));
        } else {
            abort(404);
        }
    }

    public function update(PurchaseRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        

        //Return old purchase
        $old_purchase = $this->getRecordWarehouse($data['old_warehouse_id'], $data['old_product_id']);
        $this->saveRecordWarehouse($data['old_warehouse_id'], $data['old_product_id'], $old_purchase->quantity - $data['old_quantity']);
        
        //Purchase to new warehouse
        $new_purchase = $this->getRecordWarehouse($data['warehouse_id'], $data['product_id']);
        if($new_purchase) 
        {
            $this->saveRecordWarehouse($data['warehouse_id'], $data['product_id'], $new_purchase->quantity + $data['quantity']);
        } else {
            $this->insertRecordWarehouse($data['warehouse_id'], $data['product_id'], $data['quantity']);
        }
        unset($data['old_quantity']);
        unset($data['old_product_id']);
        unset($data['old_warehouse_id']);

        Purchase::where('id', $id)->update($data);
        return redirect(route('admin.purchases.index'))->with('success', __('Update purchase successfully!'));
    }

    public function getRecordWarehouse($warehouse_id, $product_id)
    {
        return DB::table('product_of_warehouses')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->first();
    }

    public function insertRecordWarehouse($warehouse_id, $product_id, $quantity)
    {
        return DB::table('product_of_warehouses')->insert([
            'warehouse_id' => $warehouse_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);
    }

    public function saveRecordWarehouse($warehouse_id, $product_id, $quantity)
    {
        DB::table('product_of_warehouses')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->update(['quantity' => $quantity]); 
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchase = Purchase::find($id);
        $supplier = Supplier::where('id', $purchase->supplier_id)->first();
        $product = Product::where('id', $purchase->product_id)->first();
        $warehouse = Product::where('id', $purchase->warehouse_id)->first();

        if ($purchase) {
            return view('admin.purchases.view', compact(['purchase', 'supplier', 'product', 'warehouse']));
        } else {
            abort(404);
        }
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchase = Purchase::find($request->input('purchase_id'));
        if ($purchase) {
            $purchase->delete();
            if ($purchase->payment_id)
            {
                PurchasePayment::find($purchase->payment_id)->delete(); 
            }
            return redirect(route('admin.purchases.index'))->with('success', __('Delete purchase successfully!'));
        } else {
            return redirect(route('admin.purchases.index'))->with('info', __('Purchase not found!'));
        }
    }

    public function import(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        try {
            Excel::import(new PurchaseImport, $request->file);
        } catch(\Illuminate\Database\QueryException $e) {
            return redirect(route('admin.purchases.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        } catch(\ErrorException $e) {
            return redirect(route('admin.purchases.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        }
        return redirect(route('admin.purchases.index'))->with('success', __('Record are imported successfully!'));
    }
}
