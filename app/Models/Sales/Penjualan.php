<?php

namespace App\Models\Sales;

use App\Haramain\Traits\ModelTraits\{CustomerTraits, GudangTraits, StockKeluarTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory, CustomerTraits, GudangTraits, UserTraits, StockKeluarTraits;
    protected $table = 'penjualan';
    protected $fillable = [
        'kode',
        'active_cash',
        'customer_id',
        'gudang_id',
        'user_id',
        'tgl_nota',
        'tgl_tempo',
        'jenis_bayar',
        'status_bayar',
        'total_barang',
        'ppn',
        'biaya_lain',
        'total_bayar',
        'keterangan',
        'print',
    ];

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}
