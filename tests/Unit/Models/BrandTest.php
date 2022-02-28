<?php

namespace Tests\Unit\Models;

use App\Models\Brand;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class BrandTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(ProductSeeder::class);
        $this->brand = new Brand();
    }
    public function test_a_brand_has_many_products()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->brand->products());
        // kiểm tra foreignkey
        $this->assertEquals('brand_id', $this->brand->products()->getForeignKeyName());
    }
}
