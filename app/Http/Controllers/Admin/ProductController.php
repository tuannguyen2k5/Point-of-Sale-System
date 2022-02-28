<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $products = Product::paginate();
        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $brands = Brand::paginate();
        $units = Unit::paginate();
        return view('admin.products.create', compact(['brands', 'units']));
    }

    public function store(ProductRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        $path = $this->_upload($request);
        if ($path) {
            $data['photo'] = $path;
        }
        $data['expired_date'] = Carbon::createFromFormat('d/m/Y', $request->expired_date)->format('Y-m-d');
        Product::create($data);
        return redirect(route('admin.products.index'))->with('success', __('Create Product successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $product = Product::find($id);
        $brands = Brand::paginate();
        $units = Unit::paginate();
        if ($product) {
            return view('admin.products.edit', compact(['product', 'brands', 'units']));
        } else {
            abort(404);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        $path = $this->_upload($request);
        if ($path) {
            $data['photo'] = $path;
        }
        $data['expired_date'] = Carbon::createFromFormat('d/m/Y', $request->expired_date)->format('Y-m-d');
        Product::where('id', $id)->update($data);
        return redirect(route('admin.products.index'))->with('success', __('Update Product successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $Product = Product::find($request->input('product_id'));
        if ($Product) {
            $Product->delete();
            return redirect(route('admin.products.index'))->with('success', __('Delete Product successfully!'));
        } else {
            return redirect(route('admin.products.index'))->with('info', __('Product not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $product = Product::find($id);
        if ($product) {
            return view('admin.products.view', compact('product'));
        } else {
            abort(404);
        }
    }

    private function _upload($request)
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->storeAs(
                'uploads',
                $photo->getClientOriginalName()
            );
            return $path;
        }
        return false;
    }
}
