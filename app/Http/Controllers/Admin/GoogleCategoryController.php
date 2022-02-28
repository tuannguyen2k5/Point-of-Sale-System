<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoogleCategory;
use App\Http\Requests\GoogleCategoryRequest;
use App\Imports\GoogleCategoryImport;
use Excel;

class GoogleCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $google_categories = GoogleCategory::all();
        return view('admin.google-categories.index', compact('google_categories'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        return view('admin.google-categories.create');
    }

    public function store(GoogleCategoryRequest $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        GoogleCategory::create($data);
        return redirect(route('admin.google-categories.index'))->with('success', __('Create Google Category successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $google_category = GoogleCategory::find($id);
        if ($google_category) {
            return view('admin.google-categories.edit', compact('google_category'));
        } else {
            abort(404);
        }
    }

    public function update(GoogleCategoryRequest $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        GoogleCategory::where('id', $id)->update($data);
        return redirect(route('admin.google-categories.index'))->with('success', __('Update google Category successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $google_category = GoogleCategory::find($request->input('google_category_id'));
        if ($google_category) {
            $google_category->delete();
            return redirect(route('admin.google-categories.index'))->with('success', __('Delete Google Category successfully!'));
        } else {
            return redirect(route('admin.google-categories.index'))->with('info', __('Google Category not found!'));
        }
    }

    public function import(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        try {
            Excel::import(new GoogleCategoryImport, $request->file);
        } catch (\Throwable $e) {
            return redirect(route('admin.google-categories.index'))->with('warning', __('Fail to Import. Please check your file!'));
        }
        return redirect(route('admin.google-categories.index'))->with('success', __('Record are imported successfully!'));
    }
}
