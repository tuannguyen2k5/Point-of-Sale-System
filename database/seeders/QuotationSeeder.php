<?php

namespace Database\Seeders;

use App\Models\Quotation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quotations')->truncate();
        Quotation::factory(20)->create();
    }
}
