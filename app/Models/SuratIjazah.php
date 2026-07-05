<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratIjazah extends Model
{
    use HasFactory;

    protected $table = 'surat_ijazah';
    protected $primaryKey = 'id_ijazah';
    protected $fillable = [
        'id_alumni', 'file_path', 'generated_at'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
