<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnSale;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Requests\ReturnSaleRequest;
use Illuminate\Support\Facades\DB;

class ReturnSaleController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $return_sales = ReturnSale::all();
        foreach($return_sales as $return_sale)
        {
            $sale = Sale::find($return_sale->sale_id);
            $customer = Customer::find($sale->customer_id);
            $return_sale->customer = $customer->name;
        }
        return view('admin.return-sales.index', compact('return_sales'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sales = Sale::select('id')->get();
        $products = Product::select('id', 'name')->get();
        return view('admin.return-sales.create', compact(['products', 'sales']));
    }

    public function store(ReturnSaleRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $old_products = $data['old_products'];
        $new_products = $data['new_products'];

        unset($data['old_products']);
        unset($data['new_products']);
        $return_sale = ReturnSale::create($data);
        $warehouse_id = Sale::find($data['sale_id'])->warehouse_id;
       
        foreach($old_products as $old_product)
        {
            $check_product = DB::table('products_of_sale')
                ->where('sale_id', $data['sale_id'])
                ->where('product_id', $old_product['id'])
                ->first();
            if($check_product)
            {
                if($check_product->quantity < $old_product['id'])
                {
                    return redirect(route('admin.return-sales.create'))->with('warning', __('Number of product is too large'));
                } else {
                    DB::table('old_products_of_return')->insert([
                        'return_sale_id' => $return_sale->id,
                        'product_id' => $old_product['id'],
                        'quantity' => $old_product['quantity'], 
                    ]);
                } 
            } else {
                return redirect(route('admin.return-sales.create'))->with('warning', __('This product not in sale'));
            }
            $return_product = $this->getRecordWarehouse($warehouse_id, $old_product['id']);
            $this->saveRecordWarehouse($warehouse_id, $old_product['id'], $return_product->quantity + $old_product['quantity']);
        }

        foreach($new_products as $new_product)
        {
            DB::table('new_products_of_return')->insert([
                    'return_sale_id' => $return_sale->id,
                    'product_id' => $new_product['id'],
                    'quantity' => $new_product['quantity'], 
            ]);
            $return_new_product = $this->getRecordWarehouse($warehouse_id, $new_product['id']);
            if ($return_new_product)
            {
                $quantity_value = ($return_new_product->quantity - $new_product['quantity']) > 0 ? $return_new_product->quantity - $new_product['quantity'] : 0;
                $this->saveRecordWarehouse($warehouse_id, $new_product['id'], $quantity_value);
            } else {
                $this->insertRecordWarehouse($warehouse_id, $new_product['id'], 0);
            }
        }
       
        return redirect(route('admin.return-sales.index'))->with('success', __('Create return sale successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $return_sale = ReturnSale::find($id);
        $sales = Sale::select('id')->get();
        $products = Product::select('id', 'name')->get();
        $old_products = DB::table('old_products_of_return')->where('return_sale_id', $id)->get();
        $new_products = DB::table('new_products_of_return')->where('return_sale_id', $id)->get();
        if ($return_sale) {
            return view('admin.return-sales.edit', compact(['return_sale', 'sales', 'products', 'old_products', 'new_products']));
        } else {
            abort(404);
        }
    }

    public function update(ReturnSaleRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $old_products = $data['old_products'];
        $new_products = $data['new_products'];
        $old = $data['old'];
        $new = $data['new'];

        unset($data['old_products']);
        unset($data['new_products']);
        ReturnSale::where('id', $id)->update($data);

        DB::table('new_products_of_return')->where('return_sale_id', $id)->delete();
        DB::table('old_products_of_return')->where('return_sale_id', $id)->delete();
       
        foreach($old_products as $old_product)
        {
            $check_product = DB::table('products_of_sale')
                ->where('sale_id', $data['sale_id'])
                ->where('product_id', $old_product['id'])
                ->first();
            if($check_product)
            {
                if($check_product->quantity < $old_product['id'])
                {
                    return redirect(route('admin.return-sales.edit'))->with('warning', __('Number of product is too large'));
                } else {
                    DB::table('old_products_of_return')->insert([
                        'return_sale_id' => $return_sale->id,
                        'product_id' => $old_product['id'],
                        'quantity' => $old_product['quantity'], 
                    ]);
                } 
            } else {
                return redirect(route('admin.return-sales.edit'))->with('warning', __('This product not in sale'));
            }
            $return_product = $this->getRecordWarehouse($warehouse_id, $old_product['id']);
            $this->saveRecordWarehouse($warehouse_id, $old_product['id'], $return_product->quantity + $old_product['quantity']);
        }

        foreach($new_products as $new_product)
        {
            DB::table('new_products_of_return')->insert([
                    'return_sale_id' => $return_sale->id,
                    'product_id' => $new_product['id'],
                    'quantity' => $new_product['quantity'], 
            ]);
            $return_new_product = $this->getRecordWarehouse($warehouse_id, $new_product['id']);
            if ($return_new_product)
            {
                $quantity_value = ($return_new_product->quantity - $new_product['quantity']) > 0 ? $return_new_product->quantity - $new_product['quantity'] : 0;
                $this->saveRecordWarehouse($warehouse_id, $new_product['id'], $quantity_value);
            } else {
                $this->insertRecordWarehouse($warehouse_id, $new_product['id'], 0);
            }
        }

        return redirect(route('admin.sales.index'))->with('success', __('Update sale successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $return_sale_id = $request->input('return_sale_id');
        $return_sale = ReturnSale::find($return_sale_id);
        if ($return_sale) {
            $return_sale->delete();
            DB::table('old_products_of_return')->where('return_sale_id', $return_sale_id)->delete();
            DB::table('new_products_of_return')->where('return_sale_id', $return_sale_id)->delete();
            return redirect(route('admin.return-sales.index'))->with('success', __('Delete return sale successfully!'));
        } else {
            return redirect(route('admin.return-sales.index'))->with('info', __('Return sale not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $return_sale = ReturnSale::find($id);
        $sale = Sale::find($return_sale->sale_id);
        $customer = Customer::select('name')->where('id', $sale->customer_id)->first();
        $old_product_list = DB::table('old_products_of_return')->where('return_sale_id', $id)->get();
        $new_product_list = DB::table('new_products_of_return')->where('return_sale_id', $id)->get();

        $products = Product::select('id', 'name')->get();

        if ($return_sale) {
            return view('admin.return-sales.view', compact(['return_sale', 'customer', 'products', 'old_product_list', 'new_product_list']));
        } else {
            abort(404);
        }
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
