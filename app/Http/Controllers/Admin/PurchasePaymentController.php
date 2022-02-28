<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Http\Requests\PurchasePaymentRequest;
use Illuminate\Support\Facades\DB;

class PurchasePaymentController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchase_payments = PurchasePayment::orderBy('id', 'desc')->get();
        foreach($purchase_payments as $purchase_payment) 
        {
            $purchase = Purchase::where('payment_id', $purchase_payment->id)->first();
            if($purchase) 
            {
                $warehouse_id = $purchase->warehouse_id;
                $supplier_id = $purchase->supplier_id;
                $warehouse = Warehouse::where('id', $warehouse_id)->first();
                $supplier = Supplier::where('id', $supplier_id)->first();
                $type = DB::table('payment_types')->where('id', $purchase_payment->payment_type_id)->first();

                $purchase_payment->warehouse = $warehouse->name;
                $purchase_payment->supplier = $supplier->name;
                $purchase_payment->payment_type = $type->name;
                $purchase_payment->price = $purchase->price;
            }
        }
        return view('admin.purchase-payments.index', compact('purchase_payments'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchase_payment = PurchasePayment::find($id);
        $purchase = Purchase::where('payment_id', $id)->get();
        $supplier_id = $purchase[0]->supplier_id;
        $supplier = Supplier::where('id', $supplier_id)->get();
        $types = DB::table('payment_types')->get();

        $purchase_payment->purchase_id = $purchase[0]->id;
        $purchase_payment->supplier = $supplier[0]->name;
        $purchase_payment->price = $purchase[0]->price;

        if ($purchase_payment) {
            return view('admin.purchase-payments.edit', compact(['purchase_payment', 'types']));
        } else {
            abort(404);
        }
    }

    public function store(Request $request) 
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');

        $purchase_id = $data['purchase_id'];
        $purchase_payment = PurchasePayment::create(['payment_type_id' => 2]);
        if ($purchase_payment) {
            Purchase::where('id', $purchase_id)->update(['payment_id' => $purchase_payment->id]);
            return redirect(route('admin.purchase-payments.view', $purchase_payment->id));
        } else {
            abort(404);
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $purchase_payment = PurchasePayment::find($id);
        $purchase = Purchase::where('payment_id', $id)->first();
        $supplier_id = $purchase->supplier_id;
        $supplier = Supplier::where('id', $supplier_id)->first();
        $warehouse_id = $purchase->warehouse_id;
        $warehouse = Warehouse::where('id', $warehouse_id)->first();
        $type = DB::table('payment_types')->where('id', $purchase_payment->payment_type_id)->first();

        $purchase_payment->purchase_id = $purchase->id;
        $purchase_payment->supplier = $supplier->name;
        $purchase_payment->warehouse = $warehouse->name;
        $purchase_payment->price = $purchase->price;
        $purchase_payment->type = $type->name;

 
        if ($purchase_payment) {
            return view('admin.purchase-payments.view', compact('purchase_payment'));
        } else {
            abort(404);
        }
    }

    public function update(PurchasePaymentRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
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
        PurchasePayment::where('id', $id)->update($data);
        
        return redirect(route('admin.purchase-payments.index'))->with('success', __('Update delivery successfully!'));
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
        $purchase_payment_id = $request->input('purchase_payment_id');
        $purchase_payment = PurchasePayment::find($purchase_payment_id);
        if ($purchase_payment) {
            $purchase_payment->delete();
            Purchase::where('payment_id', $purchase_payment_id)->update(['payment_id' => null, 'is_complete' => false]);
            
            return redirect(route('admin.purchase-payments.index'))->with('success', __('Delete purchase payment successfully!'));
        } else {
            return redirect(route('admin.purchase-payments.index'))->with('info', __('purchase payment not found!'));
        }
    }
}
