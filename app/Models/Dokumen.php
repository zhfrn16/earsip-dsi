<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_dokumen';

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
    protected $table = 'dokumen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_dokumen',
        'id_kategori',
        'nama_dokumen',
        'no_dokumen',
        'tahun',
        'deskripsi',
        'file_dokumen'
    ];

    /**
     * Get the kategori that owns the dokumen.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Get the data arsip for the dokumen.
     */
    public function dataArsip()
    {
        return $this->hasMany(DataArsip::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Get the surat keluar for the dokumen.
     */
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Get the surat masuk for the dokumen.
     */
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'id_dokumen', 'id_dokumen');
    }
}
