<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\{CustomerTraits,
    JurnalKasTraits,
    JurnalPiutangTraits,
    JurnalTransaksiTraits,
    KodeTraits,
    UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPenjualan extends Model
{
    use HasFactory, KodeTraits, CustomerTraits, UserTraits, JurnalTransaksiTraits, JurnalKasTraits, JurnalPiutangTraits;
    protected $table = 'jurnal_penjualan';
    protected $fillable = [
        'kode',
        'active_cash',
        'tgl_jurnal',
        'customer_id',
        'total_penjualan',
        'total_biaya_lain',
        'total_hutang_ppn',
        'total_bayar',
        'total_kas',
        'total_piutang',
        'user_id',
        'keterangan',
    ];

    public function jurnal_penjualan_detail()
    {
        return $this->hasMany(JurnalPenjualanDetail::class, 'jurnal_penjualan_id');
    }
}
