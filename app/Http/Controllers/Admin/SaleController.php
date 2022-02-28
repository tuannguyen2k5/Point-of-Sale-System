<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sales = Sale::orderBy('id', 'desc')->get();
        foreach($sales as $sale)
        {
            $customer = Customer::find($sale->customer_id);
            $sale->customer = $customer->name;
        }
        return view('admin.sales.index', compact('sales'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $products = Product::select('id', 'name', 'price')->get();
        $customers = Customer::select('id', 'name')->get();
        return view('admin.sales.create', compact(['products', 'customers']));
    }

    public function store(SaleRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $products = $data['products'];
        unset($data['products']);
        $sale = Sale::create($data);
       
        foreach($products as $product)
        {
            DB::table('products_of_sale')->insert([
                    'sale_id' => $sale->id,
                    'product_id' => $product['name'],
                    'quantity' => $product['quantity'], 
            ]);
        }

        $received_money = floatval($data['price']) + floatval($data['shipping_fee']);
        $delivery = Delivery::create([
                'received_money' => $received_money, 
                'status_id' => 1,
            ]);
        $payment = SalePayment::create(['payment_type_id' => 2]);
        Sale::where('id', $sale->id)->update(['payment_id' => $payment->id, 'delivery_id' => $delivery->id]);
       
        return redirect(route('admin.sales.index'))->with('success', __('Create sale successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale = Sale::find($id);
        $products = Product::select('id', 'name', 'price')->get();
        $customers = Customer::select('id', 'name')->get();
        $product_list = DB::table('products_of_sale')->where('sale_id', $id)->get();

        if ($sale) {
            return view('admin.sales.edit', compact(['sale', 'products', 'product_list', 'customers']));
        } else {
            abort(404);
        }
    }

    public function update(SaleRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        
        $products = $data['products'];
        unset($data['products']);
        Sale::where('id', $id)->update($data);

        $old_products = DB::table('products_of_sale')->where('sale_id', $id)->delete();
       
        foreach($products as $product)
        {
            DB::table('products_of_sale')->insert([
                    'sale_id' => $id,
                    'product_id' => $product['name'],
                    'quantity' => $product['quantity'], 
            ]);
        }
        $received_money = floatval($data['price']) + floatval($data['shipping_fee']);
        Delivery::where('id', $id)->update(['received_money' => $received_money]);

        return redirect(route('admin.sales.index'))->with('success', __('Update sale successfully!'));
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale = Sale::find($id);
        $customer = Customer::select('name')->where('id', $sale->customer_id)->first();
        $product_list = DB::table('products_of_sale')->where('sale_id', $id)->get();
        $products = Product::select('id', 'name')->get();

        if ($sale) {
            return view('admin.sales.view', compact(['sale', 'customer', 'products', 'product_list']));
        } else {
            abort(404);
        }
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale_id = $request->input('sale_id');
        $sale = Sale::find($sale_id);
        if ($sale) {
            $sale->delete();
            DB::table('products_of_sale')->where('sale_id', $sale_id)->delete();
            if($sale->delivery_id)
            {
                Delivery::find($sale->delivery_id)->delete();
            }
            if($sale->payment_id)
            {
                SalePayment::find($sale->payment_id)->delete();
            }
            return redirect(route('admin.sales.index'))->with('success', __('Delete sale successfully!'));
        } else {
            return redirect(route('admin.sales.index'))->with('info', __('sale not found!'));
        }
    }

}
