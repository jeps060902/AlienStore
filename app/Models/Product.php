<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'merk',
        'harga',
        'stok',
        'subcategory_id',
        'image',
    ];

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }

    public function category()
    {
        return $this->hasOneThrough(
            ProductCategory::class,
            ProductSubcategory::class,
            'id',            // Foreign key on product_subcategories
            'id',            // Foreign key on product_categories
            'subcategory_id',
            'category_id'
        );
    }

  public function details()
{
    return $this->hasMany(ProductDetail::class, 'product_id');
}

}
