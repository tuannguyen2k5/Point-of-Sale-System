<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $brands = Brand::paginate();
        return view('admin.brands.index', compact('brands'));
    }
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.brands.create');
    }
    public function store(BrandRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Brand::create($data);
        return redirect(route('admin.brands.index'))->with('success', __('Create brands successfully!'));
    }
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $brand = Brand::find($id);
        if ($brand) {
            return view('admin.brands.edit', compact('brand'));
        } else {
            abort(404);
        }
    }
    public function update(BrandRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Brand::where('id', $id)->update($data);
        return redirect(route('admin.brands.index'))->with('success', __('Update brands successfully!'));
    }
    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $brand = Brand::find($request->input('id'));
        if ($brand) {
            $brand->delete();
            return redirect(route('admin.brands.index'))->with('success', __('Delete brand successfully!'));
        } else {
            return redirect(route('admin.brands.index'))->with('info', __('Brand not found!'));
        }
    }
    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $brand = Brand::find($id);
        if ($brand) {
            return view('admin.brands.view', compact('brand'));
        } else {
            abort(404);
        }
    }
}
