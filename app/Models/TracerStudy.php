<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    protected $table = 'tracer_study';
    protected $primaryKey = 'id_tracer';
    protected $fillable = [
        'id_alumni', 'job_status', 'job_title', 
        'company', 'city', 'filled_at'
    ];

    protected $casts = [
        'filled_at' => 'datetime',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
