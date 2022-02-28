<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacebookCategory;
use App\Http\Requests\FacebookCategoryRequest;
use App\Imports\FacebookCategoryImport;
use App\Libs\HandleCsv;
use Excel;

class FacebookCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $facebook_categories = FacebookCategory::all();
        return view('admin.facebook-categories.index', compact('facebook_categories'));
    }

    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        return view('admin.facebook-categories.create');
    }

    public function store(FacebookCategoryRequest $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        FacebookCategory::create($data);
        return redirect(route('admin.facebook-categories.index'))->with('success', __('Create Facebook Category successfully!'));
    }

    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $facebook_category = FacebookCategory::find($id);
        if ($facebook_category) {
            return view('admin.facebook-categories.edit', compact('facebook_category'));
        } else {
            abort(404);
        }
    }

    public function update(FacebookCategoryRequest $request, $id)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        FacebookCategory::where('id', $id)->update($data);
        return redirect(route('admin.facebook-categories.index'))->with('success', __('Update Facebook Category successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'employee']);
        $facebook_category = FacebookCategory::find($request->input('facebook_category_id'));
        if ($facebook_category) {
            $facebook_category->delete();
            return redirect(route('admin.facebook-categories.index'))->with('success', __('Delete Facebook Category successfully!'));
        } else {
            return redirect(route('admin.facebook-categories.index'))->with('info', __('Facebook Category not found!'));
        }
    }
    public function import(Request $request)
    {
        // Use Excel library
        $request->user()->authorizeRoles(['admin', 'employee']);
        try {
            Excel::import(new FacebookCategoryImport, $request->file);
        } catch(\Throwable $e) {
            return redirect(route('admin.facebook-categories.index'))->with('warning', __('Fail to Import. Please check your CSV file!'));
        }
        return redirect(route('admin.facebook-categories.index'))->with('success', __('Record are imported successfully!'));
        // $request->user()->authorizeRoles(['admin', 'employee']);
        // try {
        //     $categoryArr = HandleCsv::csvToArray($request->file);
        //     for ($i = 0; $i < count($categoryArr); $i++) {
        //         FacebookCategory::insert($categoryArr[$i]);
        //     }
        // } catch (\Throwable $e) {
        //     return redirect(route('admin.facebook-categories.index'))->with('warning', __('Fail to Import. Please check your file!'));
        // }
        // return redirect(route('admin.facebook-categories.index'))->with('success', __('Record are imported successfully!'));
    }
}
