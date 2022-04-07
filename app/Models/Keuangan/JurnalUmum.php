<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\KodeTraits;
use App\Haramain\Traits\ModelTraits\UserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory, UserTraits, KodeTraits;
    protected $table = 'haramain_keuangan.jurnal_umum';
    protected $fillable = [
        'active_cash',
        'kode',
        'tujuan',
        'tgl_jurnal',
        'is_persediaan_awal',
        'user_id',
        'keterangan',
    ];

    public function jurnal_transaksi()
    {
        return $this->morphMany(JurnalTransaksi::class, 'jurnalable_transaksi', 'jurnal_type', 'jurnal_id');
    }
}
