<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
        'tax_id',
        'google_category_id',
        'facebook_category_id',
        'description',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function facebookCategory()
    {
        return $this->belongsTo(FacebookCategory::class);
    }
    public function googleCategory()
    {
        return $this->belongsTo(GoogleCategory::class);
    }
}
