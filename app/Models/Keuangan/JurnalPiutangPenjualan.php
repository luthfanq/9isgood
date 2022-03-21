<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\CustomerTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPiutangPenjualan extends Model
{
    use HasFactory, CustomerTraits;
    protected $table = 'jurnal_piutang_penjualan';
    protected $fillable = [
        'kode',
        'active_cash',
        'customer_id',
        'piutang_type',
        'piutang_id',
        'akun_id',
        'nominal_debet',
        'nominal_kredit',
        'nominal_saldo',
    ];

    public function jurnalable_piutang()
    {
        return $this->morphTo(__FUNCTION__, 'piutang_type', 'piutang_id');
    }
}
