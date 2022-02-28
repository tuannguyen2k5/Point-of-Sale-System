<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $deliveries = Delivery::orderBy('id', 'desc')->get();
        foreach($deliveries as $delivery) 
        {
            $sale = Sale::where('delivery_id', $delivery->id)->first();
            $customer_id = $sale->customer_id;
            $customer = Customer::where('id', $customer_id)->get();
            $status = DB::table('delivery_status')->where('id', $delivery->status_id)->get();

            $delivery->customer = $customer[0]->name;
            $delivery->address = $customer[0]->address;
            $delivery->status = $status[0]->name;
        }
        return view('admin.deliveries.index', compact('deliveries'));
    }

    public function store(Request $request) {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');

        $sale_id = $data['sale_id'];
        $sale = Sale::find($sale_id);
        $received_money = floatval($sale->price) + floatval($sale->shipping_fee);
        $delivery = Delivery::create([
                'received_money' => $received_money, 
                'status_id' => 1,
            ]);
        if ($delivery) {
            $sale->delivery_id = $delivery->id;
            $sale->save();
            return redirect(route('admin.deliveries.view', $delivery->id));
        } else {
            abort(404);
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $delivery = Delivery::find($id);
        $sale = Sale::where('delivery_id', $delivery->id)->first();
        $customer_id = $sale->customer_id;
        $customer = Customer::where('id', $customer_id)->first();
        $status = DB::table('delivery_status')->where('id', $delivery->status_id)->first();

        $delivery->customer = $customer->name;
        $delivery->address = $customer->address;
        $delivery->status = $status->name;
        $delivery->sale_id = $sale->id;
 
        if ($delivery) {
            return view('admin.deliveries.view', compact('delivery'));
        } else {
            abort(404);
        }
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $delivery = Delivery::find($id);
        $sale = Sale::where('delivery_id', $delivery->id)->get();
        $customer_id = $sale[0]->customer_id;
        $customer = Customer::where('id', $customer_id)->get();
        $status = DB::table('delivery_status')->get();

        $delivery->customer = $customer[0]->name;
        $delivery->address = $customer[0]->address;
        $delivery->sale_id = $sale[0]->id;

        if ($sale) {
            return view('admin.deliveries.edit', compact(['delivery', 'status']));
        } else {
            abort(404);
        }
    }

    public function update(DeliveryRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        
        $status = $data['status_id'];
        if(4 == $status)
        {
            $sale = Sale::where('delivery_id', $id)->first();
            //Sale payment is complete
            SalePayment::where('id', $sale->payment_id)->update(['payment_status' => true]);
            //Sale is complete
            Sale::where('delivery_id', $id)->update(['is_complete' => true]);
            $product_list = DB::table('products_of_sale')->where('sale_id', $sale->id);
            $warehouse_id = $sale->warehouse_id;
            foreach($product_list as $product)
            {
                $check_product = $this->getRecordWarehouse($warehouse_id, $product->product_id);
                $quantity_value = ($check_product->quantity - $product->quantity) > 0 ? ($check_product->quantity - $product->quantity) : 0;
                $this->saveRecordWarehouse($warehouse_id, $product->product_id, $quantity_value);
            }
        } else {
            Sale::where('delivery_id', $id)->update(['is_complete' => false]);
        }

        Delivery::where('id', $id)->update($data);
        return redirect(route('admin.deliveries.index'))->with('success', __('Update delivery successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $delivery_id = $request->input('delivery_id');
        $delivery = Delivery::find($delivery_id);
        if ($delivery) {
            $delivery->delete();
            Sale::where('delivery_id', $delivery_id)->update(['delivery_id' => null, 'is_complete' => false]);
            
            return redirect(route('admin.deliveries.index'))->with('success', __('Delete sale successfully!'));
        } else {
            return redirect(route('admin.deliveries.index'))->with('info', __('sale not found!'));
        }
    }

    public function getRecordWarehouse($warehouse_id, $product_id)
    {
        return DB::table('product_of_warehouses')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->first();
    }

    public function saveRecordWarehouse($warehouse_id, $product_id, $new_quantity)
    {
        DB::table('product_of_warehouses')
            ->where('warehouse_id', $warehouse_id)
            ->where('product_id', $product_id)
            ->update(['quantity' => $new_quantity]); 
    }
}
