<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\GudangTraits;
use App\Haramain\Traits\ModelTraits\ProdukTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanAwalTemporary extends Model
{
    use HasFactory, GudangTraits, ProdukTraits;
    protected $table = 'haramain_keuangan.persediaan_awal_temporary';
    protected $fillable = [
        'active_cash',
        'gudang_id',
        'kondisi',
        'produk_id',
        'jumlah',
    ];
}
