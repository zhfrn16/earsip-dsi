<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'file_dokumen',
        'file',
        'jenis_surat'
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
        return $this->hasOne(SuratKeluar::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Get the surat masuk for the dokumen.
     */
    public function suratMasuk()
    {
        return $this->hasOne(SuratMasuk::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Get the file URL attribute.
     */
    public function getFileUrlAttribute()
    {
        if ($this->file) {
            return asset('storage/' . $this->file);
        }
        return null;
    }

    /**
     * Get the file name from path.
     */
    public function getFileNameAttribute()
    {
        if ($this->file) {
            return basename($this->file);
        }
        return null;
    }

    /**
     * Check if document has file.
     */
    public function hasFile()
    {
        return !empty($this->file) && Storage::disk('public')->exists($this->file);
    }
}
