<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'slug',
        'title',
        'image',
        'inc',
        'ratting',
        'parent_id',
        'category_id',
        'body',
        'plant_body',
    ];

    public function childs()
    {
        return $this->hasMany(Product::class, 'parent_id', 'product_id');
    }
}
