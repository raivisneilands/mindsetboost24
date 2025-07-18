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
        'cover_image', 'file_path', 'status',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
