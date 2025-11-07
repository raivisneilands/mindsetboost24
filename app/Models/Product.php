<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use \App\Models\DownloadLog;


class Product extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price',
        'cover_image', 'file_path', 'status', 'keywords', 'discount_price',
        'discount_start', 'discount_end',
    ];

    protected $casts = [
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
    ];

    public function downloadLogs()
    {
        return $this->hasMany(DownloadLog::class);
    }


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

    public function getActivePriceAttribute()
    {
        $now = now();
        if (
            $this->discount_price &&
            $this->discount_start &&
            $this->discount_end &&
            $now->between($this->discount_start, $this->discount_end)
        ) {
            return $this->discount_price;
        }

        return $this->price;
    }

    public function getIsDiscountActiveAttribute()
    {
        $now = now();
        return (
            $this->discount_price &&
            $this->discount_start &&
            $this->discount_end &&
            $now->between($this->discount_start, $this->discount_end)
        );
    }

}
