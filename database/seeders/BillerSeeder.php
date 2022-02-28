<?php

namespace Database\Seeders;

use App\Models\Biller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('billers')->truncate();
        Biller::factory(10)->create();
    }
}
