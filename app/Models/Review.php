<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['buku_id', 'user_id', 'review_text', 'tags'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

