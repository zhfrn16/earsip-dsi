<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surat_keluar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_dokumen',
        'tujuan_surat',
    ];

    /**
     * Get the dokumen that owns the surat keluar.
     */
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Scope for filtering by tujuan surat.
     */
    public function scopeByTujuan($query, $tujuan)
    {
        return $query->where('tujuan_surat', 'like', '%' . $tujuan . '%');
    }
}
