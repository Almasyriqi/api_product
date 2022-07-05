<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_asset()
    {
        return $this->hasMany(Product_asset::class);
    }
}
