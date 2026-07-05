<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniProfile extends Model
{
    protected $primaryKey = 'id_alumni_profiles';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'fakultas',
        'program_studi',
        'tahun_lulus',
        'status_karir',
        'avatar_url',
        'telepon',
        'alamat_lengkap',
        'provinsi',
        'kota',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }
}
