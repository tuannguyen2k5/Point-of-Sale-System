<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'manager_id',
        'name',
        'phone',
        'bank_name',
        'bank_account',
        'address',
    ];

    /**
     * Get the warehouse associated with the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'warehouse_id');
    }
}
