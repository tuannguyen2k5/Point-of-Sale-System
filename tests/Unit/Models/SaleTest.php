<?php

namespace Tests\Unit\Models;

use App\Models\Sale;
use App\Models\SalePayment;
use Database\Seeders\CustomerSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class SaleTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CustomerSeeder::class);
        $this->sale = new Sale();
    }
    public function test_sale_belongs_to_customer()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('customer_id', $this->sale->customer()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->sale->customer());
    }
    public function test_sale_has_one_sale_payment()
    {
        $this->assertInstanceOf(HasOne::class, $this->sale->salePayment());
        $this->assertEquals('payment_id', $this->sale->salePayment()->getForeignKeyName());
    }
    public function test_sale_has_one_sale_delivery()
    {
        $this->assertInstanceOf(HasOne::class, $this->sale->delivery());
        $this->assertEquals('delivery_id', $this->sale->delivery()->getForeignKeyName());
    }
    public function test_sale_has_one_return_sale()
    {
        $this->assertInstanceOf(HasOne::class, $this->sale->returnSale());
        $this->assertEquals('sale_id', $this->sale->returnSale()->getForeignKeyName());
    }
}
