<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->truncate();
        Sale::factory(200)->create();

        DB::table('payment_types')->truncate();
        DB::table('payment_types')->insert([
            [
                'name' => 'In cash',
                'description' => 'Pay in cash'
            ],
            [
                'name' => 'Online',
                'description' => 'Pay online'
            ],
            
        ]);

        DB::table('delivery_status')->truncate();
        DB::table('delivery_status')->insert([
            [
                'name' => 'Processing',
                'description' => 'Delivery is created. Shipper is on the road to warehouse.'
            ],
            [
                'name' => 'Shipped',
                'description' => 'Shipper is in warehouse and pick products of order.'
            ],
            [
                'name' => 'In Transit',
                'description' => 'Shipper is on the road to your address. Remember check your phone.'
            ],
            [
                'name' => 'Delivered',
                'description' => 'Customer received and checked goods. Delivery is complete.'
            ],
            
        ]);

        

        DB::table('products_of_sale')->truncate();
        DB::table('products_of_sale')->insert([
                [
                    'sale_id' => 1,
                    'product_id' => 1,
                    'quantity' => 3, 
                ],
                [
                    'sale_id' => 1,
                    'product_id' => 2,
                    'quantity' => 1, 
                ],
                [
                    'sale_id' => 1,
                    'product_id' => 3,
                    'quantity' => 1, 
                ],
                [
                    'sale_id' => 2,
                    'product_id' => 10,
                    'quantity' => 1, 
                ],
                [
                    'sale_id' => 3,
                    'product_id' => 19,
                    'quantity' => 2, 
                ],
                [
                    'sale_id' => 3,
                    'product_id' => 5,
                    'quantity' => 4, 
                ],
                [
                    'sale_id' => 4,
                    'product_id' => 1,
                    'quantity' => 3, 
                ],
                [
                    'sale_id' => 4,
                    'product_id' => 7,
                    'quantity' => 2, 
                ],
                [
                    'sale_id' => 5,
                    'product_id' => 4,
                    'quantity' => 1, 
                ],
                [
                    'sale_id' => 5,
                    'product_id' => 3,
                    'quantity' => 3, 
                ],
                [
                    'sale_id' => 5,
                    'product_id' => 7,
                    'quantity' => 1, 
                ],
                
            ]
        );
    }
}
