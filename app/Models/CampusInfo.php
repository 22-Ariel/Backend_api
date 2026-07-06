<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampusInfo extends Model
{
    protected $table = 'info_kampus';
    protected $primaryKey = 'id_info';

    protected $fillable = [
        'id_user',
        'judul',
        'tipe',
        'konten',
        'status',
    ];
}
