<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductPack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_percent',
        'slug',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pack_product');
    }

        protected static function boot()
        {
            parent::boot();

            static::creating(function ($pack) {
                if (empty($pack->slug)) {
                    $pack->slug = Str::slug($pack->name);
                }
            });

            static::updating(function ($pack) {
                if (empty($pack->slug)) {
                    $pack->slug = Str::slug($pack->name);
                }
            });
        }

    public function getTotalPriceAttribute(): float
    {
        return $this->products->sum('active_price');
    }

    public function getDiscountedPriceAttribute(): float
    {
        $discount = $this->discount_percent ?? 0;
        $total = $this->total_price;
        return round($total * (1 - $discount / 100), 2);
    }
}

