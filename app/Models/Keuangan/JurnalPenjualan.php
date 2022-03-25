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

    protected $connection = 'mysql2';
    protected $table = 'jurnal_penjualan';
    protected $fillable = [
        'kode',
        'active_cash',
        'penjualan_id',
    ];
}
