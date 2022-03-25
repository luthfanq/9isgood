<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\{GudangTraits, ProdukTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanPerpetual extends Model
{
    use HasFactory, GudangTraits, ProdukTraits;
    protected $connection = 'mysql2';

    protected $table = 'persediaan_perpetual';
    protected $fillable = [
        'active_cash',
        'stock_awal',
        'kode',
        'kondisi',
        'gudang_id',
        'produk_id',
        'harga',
        'jumlah',
        'sub_total',
    ];
}
