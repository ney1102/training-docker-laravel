<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'mst_product';
    protected $primaryKey = 'product_id';
    public $fillable = ['product_id', 'product_name', 'product_price', 'is_sales', 'description', 'product_image', ];

}
