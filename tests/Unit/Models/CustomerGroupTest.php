<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use App\Models\CustomerGroup;
use Database\Seeders\CustomerSeeder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CustomerGroupTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->seed(CustomerSeeder::class);
        $this->customergroup = new CustomerGroup();
    }
    public function test_a_customergroup_has_many_customers()
    {
        // kiểm tra có phải là instance của HasMany không
        $this->assertInstanceOf(HasMany::class, $this->customergroup->customers());
        // kiểm tra foreignkey
        $this->assertEquals('customer_group_id', $this->customergroup->customers()->getForeignKeyName());
    }
}
