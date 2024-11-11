<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['buku_id', 'image'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}