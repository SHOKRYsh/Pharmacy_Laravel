<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $table = "cart_items";

    protected $fillable = [
        'cart_id',
        'drug_id',
        'quantity',
        'price',
    ];


    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
    public function drug()
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }
}
