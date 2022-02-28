<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_name',
    ];
    public function categories()
    {
        return $this->hasMany(Category::class, 'facebook_category_id');
    }
}
