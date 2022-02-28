<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'supplier_id',
        'product_id',
        'quantity',
        'price',
        'purchased_date',
        'payment_id',
        'note'
    ];

    /**
     * Get the purchase payment associated with the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function purchasePayment()
    {
        return $this->hasOne(PurchasePayment::class, 'foreign_key', 'local_key');
    }
}
