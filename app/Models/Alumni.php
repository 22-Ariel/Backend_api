<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'id_alumni';
    protected $fillable = [
        'id_user', 'id_prodi', 'nim', 'nama_lengkap',
        'angkatan', 'nomor_telepon', 'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    public function tracerStudy()
    {
        return $this->hasOne(TracerStudy::class, 'id_alumni', 'id_alumni');
    }

    public function suratIjazah()
    {
        return $this->hasMany(SuratIjazah::class, 'id_alumni', 'id_alumni');
    }
}
