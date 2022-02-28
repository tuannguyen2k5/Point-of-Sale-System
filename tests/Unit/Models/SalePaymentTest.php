<?php

namespace Tests\Unit\Models;

use App\Models\SalePayment;
use Database\Seeders\SaleSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class SalePaymentTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(SaleSeeder::class);
        $this->salePayment = new SalePayment();
    }
    public function test_sale_payment_belongs_to_sale()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('payment_id', $this->salePayment->sale()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->salePayment->sale());
    }
}
