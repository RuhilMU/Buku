<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit', 'image'];
    protected $casts = [
        'tgl_terbit' => 'date',
    ];
    
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'buku_id', 'id');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'buku_id', 'id');
    }
}
