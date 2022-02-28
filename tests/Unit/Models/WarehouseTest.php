<?php

namespace Tests\Unit\Models;

use App\Models\Warehouse;
use Database\Seeders\StoreSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(StoreSeeder::class);
        $this->warehouse = new Warehouse();
    }
    public function test_warehouse_belongs_to_store()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('warehouse_id', $this->warehouse->store()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->warehouse->store());
    }
}
