<?php

namespace Tests\Unit\Models;

use App\Models\Store;
use Database\Seeders\WarehouseSeeder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class StoreTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(WarehouseSeeder::class);
        $this->store = new Store();
    }
    public function test_store_has_one_warehouse()
    {
        $this->assertInstanceOf(HasOne::class, $this->store->warehouse());
        $this->assertEquals('warehouse_id', $this->store->warehouse()->getForeignKeyName());
    }
}
