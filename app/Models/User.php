<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'username',
        'password',
        'foto',
        'id_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role that belongs to the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    /**
     * Get the role name.
     */
    public function getRoleNameAttribute()
    {
        return $this->role()->first()?->nama_role;
    }

    /**
     * Get the surat keluar for the user.
     */
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'id_user', 'id_user');
    }

    /**
     * Get the surat masuk for the user.
     */
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'id_user', 'id_user');
    }
}
