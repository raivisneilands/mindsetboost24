<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory; 


class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price',
        'cover_image', 'file_path', 'status', 'keywords',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
