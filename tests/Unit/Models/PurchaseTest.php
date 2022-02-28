<?php

namespace Tests\Unit\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->purchase = new Purchase();
    }
    public function test_purchase_has_one_purchase_payment()
    {
        $this->assertInstanceOf(HasOne::class, $this->purchase->purchasePayment());
    }
}
