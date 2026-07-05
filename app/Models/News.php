<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $primaryKey = 'id_news';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'konten',
        'gambar_url',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
