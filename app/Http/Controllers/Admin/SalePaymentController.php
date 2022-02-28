<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Requests\SalePaymentRequest;
use Illuminate\Support\Facades\DB;

class SalePaymentController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale_payments = SalePayment::orderBy('id', 'desc')->get();
        foreach($sale_payments as $sale_payment) 
        {
            $sale = Sale::where('payment_id', $sale_payment->id)->first();
            if($sale) 
            {
                $customer_id = $sale->customer_id;
                $customer = Customer::where('id', $customer_id)->first();
                $type = DB::table('payment_types')->where('id', $sale_payment->payment_type_id)->first();

                $sale_payment->customer = $customer->name;
                $sale_payment->payment_type = $type->name;
                $sale_payment->price = $sale->price;
            }
        }
        return view('admin.sale-payments.index', compact('sale_payments'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale_payment = SalePayment::find($id);
        $sale = Sale::where('payment_id', $id)->get();
        $customer_id = $sale[0]->customer_id;
        $customer = Customer::where('id', $customer_id)->get();
        $types = DB::table('payment_types')->get();

        $sale_payment->sale_id = $sale[0]->id;
        $sale_payment->customer = $customer[0]->name;
        $sale_payment->price = $sale[0]->price;

        if ($sale_payment) {
            return view('admin.sale-payments.edit', compact(['sale_payment', 'types']));
        } else {
            abort(404);
        }
    }

    public function store(Request $request) 
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');

        $sale_id = $data['sale_id'];
        $sale_payment = SalePayment::create(['payment_type_id' => 2]);
        if ($sale_payment) {
            Sale::where('id', $sale_id)->update(['payment_id' => $sale_payment->id]);
            return redirect(route('admin.sale-payments.view', $sale_payment->id));
        } else {
            abort(404);
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale_payment = SalePayment::find($id);
        $sale = Sale::where('payment_id', $id)->first();
        $customer_id = $sale->customer_id;
        $customer = Customer::where('id', $customer_id)->first();
        $type = DB::table('payment_types')->where('id', $sale_payment->payment_type_id)->first();

        $sale_payment->sale_id = $sale->id;
        $sale_payment->customer = $customer->name;
        $sale_payment->price = $sale->price;
        $sale_payment->type = $type->name;

 
        if ($sale_payment) {
            return view('admin.sale-payments.view', compact('sale_payment'));
        } else {
            abort(404);
        }
    }

    public function update(SalePaymentRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');

        $status = $data['payment_status'];
        if(true == $status)
        {
            $sale = Sale::where('payment_id', $id)->get();
            Delivery::where('id', $sale[0]->delivery_id)->update(['received_money' => 0]);
        } 
        $path = $this->_upload($request);
        if(isset($data['validate_photo']))
        {
            $path = $this->_upload($request);
            if ($path) {
                $data['validate_photo'] = $path;
            }
        } else {
            $data['validate_photo'] = $data['old_validate_photo'];
        }
        SalePayment::where('id', $id)->update($data);
        
        return redirect(route('admin.sale-payments.index'))->with('success', __('Update delivery successfully!'));
    }

    private function _upload($request)
    {
        if ($request->hasFile('validate_photo')) {
            $photo = $request->file('validate_photo');
            $path = $photo->storeAs(
                'uploads',
                $photo->getClientOriginalName()
            );
            return $path;
        }
        return false;
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $sale_payment_id = $request->input('sale_payment_id');
        $sale_payment = SalePayment::find($sale_payment_id);
        if ($sale_payment) {
            $sale_payment->delete();
            Sale::where('payment_id', $sale_payment_id)->update(['payment_id' => null, 'is_complete' => false]);
            
            return redirect(route('admin.sale-payments.index'))->with('success', __('Delete sale payment successfully!'));
        } else {
            return redirect(route('admin.sale-payments.index'))->with('info', __('sale payment not found!'));
        }
    }
}
