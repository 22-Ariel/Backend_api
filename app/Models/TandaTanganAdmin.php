<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TandaTanganAdmin extends Model
{
    use HasFactory;

    protected $table = 'tanda_tangan_admin';
    protected $primaryKey = 'id_ttd';
    protected $fillable = [
        'id_user', 'file_path'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
