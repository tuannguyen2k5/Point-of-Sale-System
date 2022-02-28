<?php

namespace Tests\Unit\Models;

use App\Models\GoogleCategory;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class GoogleCategoryTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
        $this->googleCategory = new GoogleCategory();
    }
    public function test_a_google_category_has_many_categories()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->googleCategory->categories());
        // kiểm tra foreignkey
        $this->assertEquals('google_category_id', $this->googleCategory->categories()->getForeignKeyName());
    }
}
