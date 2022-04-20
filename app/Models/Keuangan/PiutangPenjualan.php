<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\PenjualanTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiutangPenjualan extends Model
{
    use HasFactory, PenjualanTraits;
    protected $connection = 'mysql2';
    protected $table = 'piutang_penjualan';

    protected $fillable = [
        'saldo_piutang_penjualan_id',
        'jurnal_set_piutang_awal_id',
        'penjualan_id',
        'status_bayar', // enum ['lunas', 'belum', 'kurang']
        'kurang_bayar',
    ];

    public function saldo_piutang_penjualan()
    {
        return $this->belongsTo(SaldoPiutangPenjualan::class, 'saldo_piutang_penjualan_id', 'customer_id');
    }

    public function jurnal_set_piutang_awal()
    {
        return $this->belongsTo(JurnalSetPiutangAwal::class, 'jurnal_set_piutang_awal_id');
    }
}
