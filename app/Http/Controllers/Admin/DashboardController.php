<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        // Get 12 latest months revenue 
        $month = array();
        $revenue = array();
        
        for($i=0;$i<12;$i++)
        {
            $date = new \DateTime();

            $time_string = '-'.$i.' months';
            $month[$i] = $date->modify($time_string)->format('M Y');
            $revenue[$i] = $this->getTotalSalesInMonth($i);
        }

        // Get 5 latest sale
        $latest_sales = Sale::where('is_complete', 1)->orderBy('order_date', 'desc')->take(5)->get();
        foreach($latest_sales as $latest_sale)
        {
            $customer = Customer::find($latest_sale->customer_id);
            $latest_sale->customer = $customer->name;
        }

        // Get top 5 in years
        $date = new \DateTime();

        $top_years = \DB::table('products_of_sale')
            ->join('sales', 'sales.id', '=', 'products_of_sale.sale_id')
            ->join('products', 'products.id', '=' , 'products_of_sale.product_id')
            ->select('products_of_sale.product_id', 'products.name',\DB::raw('sum(products_of_sale.quantity) as total'))
            ->groupBy('products_of_sale.product_id')
            ->whereYear('sales.order_date', $date->format('Y'))
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        return view('admin.dashboard', compact(['month', 'revenue', 'latest_sales', 'top_years']));
        
        return view('admin.dashboard');
    }

    public function getTotalSalesInMonth($offset)
    {
        $date = new \DateTime();

        $time_string = '-'.$offset.' months';
        $year = $date->modify($time_string)->format('Y');
        $month = $date->modify($time_string)->format('m');

        $sales_in_month = Sale::where('is_complete', 1)
                            ->whereYear('order_date', '=', $year)
                            ->whereMonth('order_date', '=', $month)
                            ->get();
        $total = 0;
        foreach ($sales_in_month as $sale) {
            $total += floatval($sale->price) + floatval($sale->shipping_fee);
        }
        return $total;
    } 
}
