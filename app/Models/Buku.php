<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit', 'image', 'editorial_pick', 'discount', 'discount_percentage'];
    protected $casts = [
        'tgl_terbit' => 'date', 
        'discount' => 'boolean',
    ];
    
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount && $this->discount_percentage) {
            return $this->harga - ($this->harga * $this->discount_percentage / 100);
        }
        return $this->harga;
    }
    
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'buku_id', 'id');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'buku_id', 'id');
    }
}
