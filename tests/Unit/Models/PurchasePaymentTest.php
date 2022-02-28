<?php

namespace Tests\Unit\Models;

use App\Models\PurchasePayment;
use Database\Seeders\PurchaseSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class PurchasePaymentTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(PurchaseSeeder::class);
        $this->purchasePayment = new PurchasePayment();
    }
    public function test_purchase_payment_belongs_to_purchase()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('payment_id', $this->purchasePayment->purchase()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->purchasePayment->purchase());
    }
}
