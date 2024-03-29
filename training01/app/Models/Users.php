<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'mst_users';
    protected $casts = [
        'password' => 'hashed',
    ];
    public $timestamps = true;
    public $fillable = ['id', 'name', 'email', 'password', 'group_role', 'remember_token', 'is_active', 'is_delete', 'last_login_at', 'last_login_ip', 'created_at', 'updated_at'];
}

