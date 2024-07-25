<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemAddOn extends Model
{
    use HasFactory;
    protected $table = 'cart_item_add_on';
    public $timestamps = false;
    protected $fillable = [ 
        'id',
        'cart_item_id',
        'product_id',
        'ingredient_id',
        'quantity',
        'unit_price',
        'sub_total',
        'created_date',
        'modified_date'
    ];
}
