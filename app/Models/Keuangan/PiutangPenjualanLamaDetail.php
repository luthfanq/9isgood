<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\CustomerTraits;
use App\Haramain\Traits\ModelTraits\UserTraits;
use App\Models\Penjualan\Penjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiutangPenjualanLamaDetail extends Model
{
    use HasFactory, CustomerTraits, UserTraits;
    protected $table = 'haramain_keuangan.piutang_penjualan_lama_detail';

    protected $fillable = [
        'piutang_penjualan_lama_id',
        'penjualan_id',
        'total_bayar',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function piutangPenjualanLama()
    {
        return $this->belongsTo(PiutangPenjualanLama::class, 'piutang_penjualan_lama_id');
    }
}
