<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'id_lowongan';
    protected $fillable = [
        'id_user', 'title', 'company', 'location', 
        'description', 'url', 'deadline'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
