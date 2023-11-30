<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SebastianBergmann\Type\VoidType;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'slug',
        'title',
        'image',
        'size',
        'price',
        'ratting',
        'category_id',
        'body',
        'plant_body',
    ];

    protected function size(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode($value),
            get: fn ($value) => json_decode($value),
        );
    }

    // public function getSizeAttribute($value)
    // {
    //     return json_decode($value);
    // }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
