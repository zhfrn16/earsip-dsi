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
    protected $primaryKey = 'id_surat_keluar';

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
    protected $table = 'surat_keluar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_surat_keluar',
        'id_dokumen',
        'id_user',
        'file',
        'no_surat',
        'tanggal',
        'sifat_surat',
        'pengirim',
        'perihal',
        'tertuj',
        'alamat',
        'isi_surat',
        'status',
        'status_persetujuan_staff',
        'status_persetujuan_kadep',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'datetime',
        'status_persetujuan_staff' => 'boolean',
        'status_persetujuan_kadep' => 'boolean',
    ];

    /**
     * Get the dokumen that owns the surat keluar.
     */
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen', 'id_dokumen');
    }

    /**
     * Get the user that owns the surat keluar.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for approved letters (both staff and kadep approved).
     */
    public function scopeApproved($query)
    {
        return $query->where('status_persetujuan_staff', true)
                     ->where('status_persetujuan_kadep', true);
    }

    /**
     * Get status text attribute.
     */
    public function getStatusTextAttribute()
    {
        $statusMap = [
            0 => 'Draft',
            1 => 'Menunggu Persetujuan',
            2 => 'Disetujui',
            3 => 'Ditolak',
            4 => 'Dikirim'
        ];

        return $statusMap[$this->status] ?? 'Unknown';
    }
}
