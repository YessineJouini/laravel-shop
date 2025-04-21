<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\order;

class User extends Authenticatable
{
    
    
    use HasFactory, Notifiable; // ✅ Place HasFactory at the top

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class); // Ensure 'user_id' matches your database column
    }
    

    protected $fillable = ['name', 'email', 'password', 'role'];
    public function cart()
{
    return $this->hasOne(Cart::class);
}
    
}

$user = Auth::user(); // Ensure this is an instance of App\Models\User
