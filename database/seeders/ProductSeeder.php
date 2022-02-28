<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        DB::table('brands')->truncate();
        DB::table('units')->truncate();
        Product::factory()
            ->count(20)
            ->for(Brand::factory())
            ->for(Unit::factory())
            ->create();
    }
}
