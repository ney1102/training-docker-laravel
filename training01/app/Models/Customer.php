<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'mst_customer';
    public $timestamps = false;
    public $fillable = ['customer_name', 'email', 'is_active', 'tel_num', 'address','created_at', 'updated_at'];
    protected $primaryKey = 'customer_id';
}