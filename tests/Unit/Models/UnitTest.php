<?php

namespace Tests\Unit\Models;

use App\Models\Unit;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class UnitTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(ProductSeeder::class);
        $this->unit = new Unit();
    }
    public function test_a_unit_has_many_products()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->unit->products());
        // kiểm tra foreignkey
        $this->assertEquals('unit_id', $this->unit->products()->getForeignKeyName());
    }
}
