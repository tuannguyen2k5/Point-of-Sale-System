<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
        $this->category = new Category();
    }
    public function test_a_category_has_many_products()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->category->products());
        // kiểm tra foreignkey
        $this->assertEquals('category_id', $this->category->products()->getForeignKeyName());
    }
    public function test_category_belongs_to_facebook_category()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('facebook_category_id', $this->category->facebookCategory()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->category->facebookCategory());
    }
    public function test_category_belongs_to_google_category()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('google_category_id', $this->category->googleCategory()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->category->googleCategory());
    }
}
