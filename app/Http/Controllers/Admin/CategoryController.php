<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\FacebookCategory;
use App\Models\GoogleCategory;
use App\Models\TaxRate;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $categories = Category::all();
        foreach ($categories as $category) {
            $parent = Category::find($category->parent_id);
            $category->parent = $parent->name;

            $tax_rate = TaxRate::find($category->tax_id);
            $category->tax = $tax_rate->value;
        }

        return view('admin.categories.index', compact('categories'));
    }
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $facebook_categories = FacebookCategory::all();
        $google_categories = GoogleCategory::all();
        $tax_rates = TaxRate::select('id', 'name', 'value')->get();
        $categories = Category::select('id', 'name')->get();

        return view('admin.categories.create', compact([
            'facebook_categories', 'google_categories',
            'categories', 'tax_rates'
        ]));
    }
    public function store(CategoryRequest $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_token');
        $data = array_filter($data, 'strlen');
        Category::create($data);
        return redirect(route('admin.categories.index'))->with('success', __('Create Category successfully!'));
    }
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $facebook_categories = FacebookCategory::all();
        $google_categories = GoogleCategory::all();
        $tax_rates = TaxRate::select('id', 'name', 'value')->get();
        $categories = Category::select('id', 'name')->get();

        $category = Category::find($id);
        if ($category) {
            return view('admin.categories.edit', compact([
                'category', 'facebook_categories',
                'google_categories', 'categories', 'tax_rates'
            ]));
        } else {
            abort(404);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $data = $request->except('_method', '_token');
        $data = array_filter($data, 'strlen');
        Category::where('id', $id)->update($data);
        return redirect(route('admin.categories.index'))->with('success', __('Update Category successfully!'));
    }

    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $category = Category::find($request->input('category_id'));
        if ($category) {
            $category->delete();
            return redirect(route('admin.categories.index'))->with('success', __('Delete Category successfully!'));
        } else {
            return redirect(route('admin.categories.index'))->with('info', __('Category not found!'));
        }
    }

    public function view(Request $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $category = Category::find($id);
        //get parent category name of category
        $parent = Category::find($category->parent_id);
        $category->parent = $parent->name;
        //get facebook category name of category
        $facebook_category = FacebookCategory::where('category_id', $category->facebook_category_id)->first();
        if ($facebook_category) {
            $category->facebook_category = $facebook_category->category_name;
        }
        //get google category name of category
        $google_category = GoogleCategory::where('category_id', $category->google_category_id)->first();
        if ($google_category) {
            $category->google_category = $google_category->category_name;
        }
        //get tax rate of category
        $tax_rate = TaxRate::find($category->tax_id);
        if ($category) {
            return view('admin.categories.view', compact(['category', 'tax_rate']));
        } else {
            abort(404);
        }
    }

    public function googleExport(Request $request){
        $request->user()->authorizeRoles(['employee', 'admin']);
        $category_id = $request->category_id;
        $products = Product::where('category_id', $category_id)->get();
        $category = Category::find($category_id);
        $xml = new \SimpleXMLElement('<rss xmlns:g="http://base.google.com/ns/1.0" />');
        $xml->addAttribute('version', '1.0');
        $chanel = $xml->addChild('chanel');
        $chanel->addChild('title', $category->name);
        $chanel->addChild('link', route('admin.products.view', $category->id));
        $chanel->addChild('description', $category->description);

        foreach ($products as $product) {
            $item = $chanel->addChild('item');
            $item->addChild('id', $product->id, "http://base.google.com/ns/1.0");
            $item->addChild('title', $product->name, "http://base.google.com/ns/1.0");
            $item->addChild('description', $product->description, "http://base.google.com/ns/1.0");
            $item->addChild('link', route('admin.products.view', $product->id), "http://base.google.com/ns/1.0");
            $item->addChild('image_link', $product->photo, "http://base.google.com/ns/1.0");
            $item->addChild('condition', 'New', "http://base.google.com/ns/1.0");
            $item->addChild('availability', 'In Stock', "http://base.google.com/ns/1.0");
            $item->addChild('price', $product->price.' VND', "http://base.google.com/ns/1.0");
            $item->addChild('brand', $product->brand->name, "http://base.google.com/ns/1.0");
            $item->addChild('google_product_category', $product->category->google_category_id, "http://base.google.com/ns/1.0");
        }

        $xml->saveXML('google-products.xml');

        $response = \Response::make($xml->asXML(), 200);
        $response->header('Cache-Control', 'public');
        $response->header('Content-Description', 'File Transfer');
        $response->header('Content-Disposition', 'attachment; filename=google-products.xml');
        $response->header('Content-Transfer-Encoding', 'binary');
        $response->header('Content-Type', 'text/xml');

        return $response;
    }

    public function facebookExport(Request $request){
        $request->user()->authorizeRoles(['employee', 'admin']);
        $category_id = $request->category_id;
        $products = Product::where('category_id', $category_id)->get();
        $category = Category::find($category_id);
        $xml = new \SimpleXMLElement('<rss xmlns:g="http://base.google.com/ns/1.0" />');
        $xml->addAttribute('version', '1.0');
        $chanel = $xml->addChild('chanel');
        $chanel->addChild('title', $category->name);
        $chanel->addChild('link', route('admin.products.view', $category->id));
        $chanel->addChild('description', $category->description);

        foreach ($products as $product) {
            $item = $chanel->addChild('item');
            $item->addChild('id', $product->id, "http://base.google.com/ns/1.0");
            $item->addChild('title', $product->name, "http://base.google.com/ns/1.0");
            $item->addChild('description', $product->description, "http://base.google.com/ns/1.0");
            $item->addChild('link', route('admin.products.view', $product->id), "http://base.google.com/ns/1.0");
            $item->addChild('image_link', $product->photo, "http://base.google.com/ns/1.0");
            $item->addChild('condition', 'New', "http://base.google.com/ns/1.0");
            $item->addChild('availability', 'In Stock', "http://base.google.com/ns/1.0");
            $item->addChild('price', $product->price.' VND', "http://base.google.com/ns/1.0");
            $item->addChild('brand', $product->brand->name, "http://base.google.com/ns/1.0");
            $item->addChild('google_product_category', $product->category->google_category_id, "http://base.google.com/ns/1.0");
            $item->addChild('quantity_to_sell_on_facebook', $product->quantity, "http://base.google.com/ns/1.0");
        }

        $xml->saveXML('facebook-products.xml');

        $response = \Response::make($xml->asXML(), 200);
        $response->header('Cache-Control', 'public');
        $response->header('Content-Description', 'File Transfer');
        $response->header('Content-Disposition', 'attachment; filename=facebook-products.xml');
        $response->header('Content-Transfer-Encoding', 'binary');
        $response->header('Content-Type', 'text/xml');

        return $response;
    }
}
