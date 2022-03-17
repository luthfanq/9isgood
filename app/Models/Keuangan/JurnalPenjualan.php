<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\{CustomerTraits, JurnalKasTraits, JurnalTransaksiTraits, KodeTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPenjualan extends Model
{
    use HasFactory, KodeTraits, CustomerTraits, UserTraits, JurnalTransaksiTraits, JurnalKasTraits;
    protected $table = 'jurnal_penjualan';
    protected $fillable = [
        'kode',
        'active_cash',
        'tgl_jurnal',
        'customer_id',
        'total_penjualan',
        'akun_biaya_lain',
        'total_biaya_lain',
        'akun_hutang_ppn',
        'total_hutang_ppn',
        'total_bayar',
        'user_id',
        'keterangan',
    ];

    public function akunBiayaLain()
    {
        return $this->belongsTo(Akun::class, 'akun_biaya_lain');
    }

    public function akunHutangPpn()
    {
        return $this->belongsTo(Akun::class, 'akun_hutang_ppn');
    }
}
