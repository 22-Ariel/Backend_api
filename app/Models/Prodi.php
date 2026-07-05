<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    protected $fillable = ['id_fakultas', 'nama_prodi'];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas', 'id_fakultas');
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'id_prodi', 'id_prodi');
    }
}
