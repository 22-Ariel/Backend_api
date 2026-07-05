<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['username', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function alumni()
    {
        return $this->hasOne(Alumni::class, 'id_user', 'id_user');
    }

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'id_user', 'id_user');
    }

    public function infoKampus()
    {
        return $this->hasMany(CampusInfo::class, 'id_user', 'id_user');
    }

    public function tandaTangan()
    {
        return $this->hasOne(TandaTanganAdmin::class, 'id_user', 'id_user');
    }
}
