<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
        $this->product = new Product();
    }
    public function test_product_belongs_to_category()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('category_id', $this->product->category()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->product->category());
    }
    public function test_product_belongs_to_user()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('created_by', $this->product->createdBy()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->product->createdBy());
    }
    public function test_product_belongs_to_brand()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('brand_id', $this->product->brand()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->product->brand());
    }
    public function test_product_belongs_to_unit()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('unit_id', $this->product->unit()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->product->unit());
    }
}
