<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount_product extends Model
{
    use HasFactory;
    protected $table = 'discount_products';
    protected $guarded = [];
    public function discount(){
        return $this->belongsTo(discount::class, 'discount_id');
    }
}
