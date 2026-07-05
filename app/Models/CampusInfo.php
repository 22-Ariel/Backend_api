<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampusInfo extends Model
{
    protected $table = 'campus_info';
    protected $primaryKey = 'id_campus_info';

    protected $fillable = [
        'judul',
        'tipe',
        'konten',
        'status',
    ];
}
