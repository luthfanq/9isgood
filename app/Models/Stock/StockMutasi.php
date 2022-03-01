<?php

namespace App\Models\Stock;

use App\Haramain\Traits\ModelTraits\{GudangTraits, KodeTraits, StockKeluarTraits, StockMasukTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutasi extends Model
{
    use HasFactory, KodeTraits, GudangTraits, UserTraits;
    use StockMasukTraits, StockKeluarTraits;

    protected $table = 'stock_mutasi';
    protected $fillable = [
        'active_cash',
        'kode',
        'jenis_mutasi',
        'gudang_asal_id',
        'gudang_tujuan_id',
        'tgl_mutasi',
        'user_id',
        'keterangan',
    ];

    public function stockMutasiDetail()
    {
        return $this->hasMany(StockMutasiDetail::class, 'stock_mutasi_id');
    }
}
