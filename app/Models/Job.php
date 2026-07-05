<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $primaryKey = 'id_jobs';

    protected $fillable = [
        'posisi',
        'perusahaan',
        'tipe_pekerjaan',
        'lokasi',
        'gaji',
        'deskripsi',
        'persyaratan',
        'batas_waktu',
        'status',
    ];
}
