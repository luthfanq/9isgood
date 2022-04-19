<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\CustomerTraits;
use App\Haramain\Traits\ModelTraits\UserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiutangPenjualanLama extends Model
{
    use HasFactory, CustomerTraits, UserTraits;
    protected $table = 'haramaian_keuangan.piutang_penjualan_lama';
    protected $fillable = [
        'tahun_nota',
        'customer_id',
        'user_Id',
        'total_piutang',
        'keterangan',
    ];

    public function piutangPenjualanLamaDetail()
    {
        return $this->hasMany(PiutangPenjualanLamaDetail::class, 'piutang_penjualan_lama_id');
    }

    public function jurnalTransaksi()
    {
        return $this->morphMany(JurnalTransaksi::class, 'jurnalable_transaksi', 'jurnal_type', 'jurnal_id');
    }
}
