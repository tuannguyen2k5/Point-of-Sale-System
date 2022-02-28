<?php

namespace Tests\Unit\Models;

use App\Models\ReturnSale;
use Database\Seeders\SaleSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ReturnSaleTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(SaleSeeder::class);
        $this->returnSale = new ReturnSale();
    }
    public function test_sale_payment_belongs_to_sale()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('sale_id', $this->returnSale->sale()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->returnSale->sale());
    }
}
