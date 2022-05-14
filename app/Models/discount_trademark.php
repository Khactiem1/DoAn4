<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount_trademark extends Model
{
    use HasFactory;
    protected $table = 'discount_trademarks';
    protected $guarded = [];
    public function discount(){
        return $this->belongsTo(discount::class, 'discount_id');
    }
}
