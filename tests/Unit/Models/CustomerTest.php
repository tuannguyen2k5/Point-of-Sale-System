<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\Sale;
use Database\Seeders\CustomerSeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CustomerSeeder::class);
        $this->customer = new Customer();
    }
    public function test_a_customer_has_many_sales()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->customer->sales());
        // kiểm tra foreignkey
        $this->assertEquals('customer_id', $this->customer->sales()->getForeignKeyName());
    }
    public function test_customer_belongs_to_customergroup()
    {
        // kiểm tra foreignkey có giống nhau không
        $this->assertEquals('customergroup_id', $this->customer->customergroup()->getForeignKeyName());

        // kiểm tra instance BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $this->customer->customergroup());
    }
}
