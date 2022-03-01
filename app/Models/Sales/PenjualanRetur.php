<?php

namespace App\Models\Sales;

use App\Haramain\Traits\ModelTraits\{CustomerTraits, GudangTraits, KodeTraits, StockMasukTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanRetur extends Model
{
    use HasFactory, KodeTraits, CustomerTraits, GudangTraits, UserTraits, StockMasukTraits;
    protected $table = 'penjualan_retur';
    protected $fillable = [
        'kode',
        'active_cash',
        'jenis_retur',
        'customer_id',
        'gudang_id',
        'user_id',
        'tgl_nota',
        'tgl_tempo',
        'status_bayar',
        'total_barang',
        'ppn',
        'biaya_lain',
        'total_bayar',
        'keterangan',
    ];
}
