<?php

namespace Tests\Unit\Models;

use App\Models\FacebookCategory;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class FacebookCategoryTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
        $this->facebookCategory = new FacebookCategory();
    }
    public function test_a_facebook_category_has_many_categories()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->facebookCategory->categories());
        // kiểm tra foreignkey
        $this->assertEquals('facebook_category_id', $this->facebookCategory->categories()->getForeignKeyName());
    }
}
