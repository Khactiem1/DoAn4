<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';
    protected $guarded = [];
    public function products(){
        return $this->hasMany(discount_product::class,'discount_id');
    }
    public function trademarks(){
        return $this->hasMany(discount_trademark::class,'discount_id');
    }
}
