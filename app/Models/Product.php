<?php

namespace App\Models;
use App\Models\Category; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory; 
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
    ];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function averageRating()
{
    return $this->reviews()->avg('rating');
}
    public function reviews()
{
    return $this->hasMany(Review::class);
}
    
    public function wishlistedBy()
{
    return $this->belongsToMany(User::class, 'wishlist_items')
                ->withTimestamps();
}
public function sale()
{
    return $this->hasOne(\App\Models\Sale::class);
}
public function getDiscountedPriceAttribute()
{
    if ($this->sale && $this->sale->isActive()) {
        return round($this->price * (1 - $this->sale->discount_percent / 100), 2);
    }
    return $this->price;
}

}
