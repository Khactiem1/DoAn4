<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];
    public function images(){
        return $this->hasMany(ProductImage::class,'product_id');
    }
    public function options(){
        return $this->hasMany(ProductOption::class,'product_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function trademark(){
        return $this->belongsTo(trademark::class, 'trademark_id');
    }
}
