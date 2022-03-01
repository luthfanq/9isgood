<?php

namespace App\Models\Purchase;

use App\Haramain\Traits\ModelTraits\{KodeTraits, SupplierTraits, GudangTraits, UserTraits, StockMasukTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory, KodeTraits, SupplierTraits, GudangTraits, UserTraits, StockMasukTraits;
    protected $table = 'pembelian';
    protected $fillable = [
        'kode',
        'active_cash',
        'supplier_id',
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

}
