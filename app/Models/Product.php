<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama', 'merk', 'harga', 'stok'
    ];
    public function details()
{
    return $this->hasMany(ProductDetail::class);
}

}
