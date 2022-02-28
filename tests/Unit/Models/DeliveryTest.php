<?php

namespace Tests\Unit\Models;

use App\Models\Delivery;
use Database\Seeders\SaleSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(SaleSeeder::class);
        $this->delivery = new Delivery();
    }
    public function test_delivery_belongs_to_sale()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('delivery_id', $this->delivery->sale()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->delivery->sale());
    }
}
