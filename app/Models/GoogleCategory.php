<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_name',
    ];

    
    public function categories()
    {
        return $this->hasMany(Category::class, 'google_category_id');
    }
}
