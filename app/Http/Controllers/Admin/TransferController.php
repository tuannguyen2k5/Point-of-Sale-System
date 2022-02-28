<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Warehouse;
use App\Models\Product;
use App\Http\Requests\TransferRequest;
use App\Imports\TransferImport;
use Excel;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $transfers = Transfer::orderBy('id', 'desc')->get();
        foreach($transfers as $transfer)
        {
            $source_warehouse = Warehouse::find($transfer->source_warehouse_id);
            $dest_warehouse = Warehouse::find($transfer->dest_warehouse_id);
            $product = Product::find($transfer->product_id);

            $transfer->source_warehouse = $source_warehouse->name;
            $transfer->dest_warehouse = $dest_warehouse->name;
            $transfer->product = $product->name;
        }
        return view('admin.transfers.index', compact('transfers'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $warehouses = Warehouse::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        return view('admin.transfers.create', compact(['warehouses', 'products']));
    }

    public function store(TransferRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $source_warehouse = $this->getRecordWarehouse($data['source_warehouse_id'], $data['product_id']);
        if ($source_warehouse->quantity < $data['quantity'])//not enough product in source warehouse
        {
            return redirect(route('admin.transfers.create'))->with('warning', __('Not enough product in source warehouse'));
        } else {
            $new_source_quantity = $source_warehouse->quantity - $data['quantity'];
            $this->saveRecordWarehouse($data['source_warehouse_id'], $data['product_id'], $new_source_quantity);
            
            $dest_warehouse = $this->getRecordWarehouse($data['dest_warehouse_id'], $data['product_id']);
            if ($dest_warehouse)//product exist in dest warehouse
            {
                $new_dest_quantity = $dest_warehouse->quantity + $data['quantity'];
                $this->saveRecordWarehouse($data['dest_warehouse_id'], $data['product_id'], $new_dest_quantity);
            } else {
                $this->insertRecordWarehouse($data['dest_warehouse_id'], $data['product_id'], $data['quantity']);
            }
        }
        Transfer::create($data);
        return redirect(route('admin.transfers.index'))->with('success', __('Create transfer successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $transfer = Transfer::find($id);
        $warehouses = Warehouse::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();
        if ($transfer) {
            return view('admin.transfers.edit', compact(['transfer', 'warehouses', 'products']));
        } else {
            abort(404);
        }
    }

    public function update(TransferRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');

        //get product of old dest warehouse
        $old_dest = $this->getRecordWarehouse( $data['old_dest_warehouse_id'], $data['old_product_id']);
        $this->saveRecordWarehouse($data['old_dest_warehouse_id'], $data['old_product_id'], $old_dest->quantity - $data['old_quantity']);

        //Return product to old source warehouse
        $old_source = $this->getRecordWarehouse($data['old_source_warehouse_id'], $data['old_product_id']);
        $this->saveRecordWarehouse($data['old_source_warehouse_id'], $data['old_product_id'], $old_source->quantity + $data['old_quantity']);

        //Transfer new source warehouse to new dest warehouse
        $new_source = $this->getRecordWarehouse($data['source_warehouse_id'], $data['product_id']);
        $this->saveRecordWarehouse($data['source_warehouse_id'], $data['product_id'], $new_source->quantity - $data['quantity']);
        $new_dest = $this->getRecordWarehouse($data['dest_warehouse_id'], $data['product_id']);
        if ($new_dest)//product exist in warehouse
        {
            $this->saveRecordWarehouse($data['dest_warehouse_id'], $data['product_id'], $new_dest->quantity + $data['quantity']);
        } else {
            $this->insertRecordWarehouse($data['dest_warehouse_id'], $data['product_id'], $data['quantity']);
        }

        Transfer::where('id', $id)->update($data);
        return redirect(route('admin.transfers.index'))->with('success', __('Update transfer successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $transfer = Transfer::find($request->input('transfer_id'));
        if ($transfer) {
            $transfer->delete();
            return redirect(route('admin.transfers.index'))->with('success', __('Delete transfer successfully!'));
        } else {
            return redirect(route('admin.transfers.index'))->with('info', __('Transfer not found!'));
        }
    }
    
    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $transfer = Transfer::find($id);
        $product = Product::where('id', $transfer->product_id)->first();
        $source_warehouse = Product::where('id', $transfer->source_warehouse_id)->first();
        $dest_warehouse = Product::where('id', $transfer->dest_warehouse_id)->first();

        if ($transfer) {
            return view('admin.transfers.view', compact(['transfer', 'product', 'source_warehouse', 'dest_warehouse']));
        } else {
            abort(404);
        }
    }

    public function import(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        try {
            Excel::import(new TransferImport, $request->file);
        } catch(\Illuminate\Database\QueryException $e) {
            return redirect(route('admin.transfers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        } catch(\ErrorException $e) {
            return redirect(route('admin.transfers.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        }
        return redirect(route('admin.transfers.index'))->with('success', __('Record are imported successfully!'));
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

    public function saveRecordWarehouse($warehouse_id, $product_id, $new_quantity)
    {
        DB::table('product_of_warehouses')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->update(['quantity' => $new_quantity]); 
    }
}
