<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'price',
        'shipping_fee',
        'is_complete',
        'note'
    ];

    /**
     * Get the customer that owns the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the sale payment associated with the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function salePayment()
    {
        return $this->hasOne(SalePayment::class, 'payment_id');
    }

    /**
     * Get the delivery associated with the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'delivery_id');
    }

    /**
     * Get the return sale associated with the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function returnSale()
    {
        return $this->hasOne(ReturnSale::class, 'sale_id');
    }
}
