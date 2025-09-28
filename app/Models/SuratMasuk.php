<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_surat_masuk';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surat_masuk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_surat_masuk',
        'id_dokumen',
        'id_user',
        'file',
        'no_surat',
        'tanggal',
        'sifat_surat',
        'pengirim',
        'perihal',
        'isi_surat',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the dokumen that owns the surat masuk.
     */
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Get the user that owns the surat masuk.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Scope for filtering by sifat surat.
     */
    public function scopeBySifat($query, $sifat)
    {
        return $query->where('sifat_surat', $sifat);
    }

    /**
     * Scope for filtering by pengirim.
     */
    public function scopeByPengirim($query, $pengirim)
    {
        return $query->where('pengirim', 'like', '%' . $pengirim . '%');
    }

    /**
     * Scope for filtering by periode tanggal.
     */
    public function scopeByPeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }
}
