<?php

namespace App\Models\Stock;

use App\Haramain\Traits\ModelTraits\{GudangTraits, KodeTraits, PegawaiTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAkhir extends Model
{
    use HasFactory, GudangTraits, UserTraits, PegawaiTraits, KodeTraits;
    protected $table = 'stock_akhir';
    protected $fillable = [
        'active_cash',
        'kode',
        'jenis',
        'tgl_input',
        'gudang_id',
        'user_id',
        'pegawai_id',
        'keterangan',
    ];

    public function stock_akhir_detail()
    {
        return $this->hasMany(StockAkhirDetail::class, 'stock_akhir_id');
    }
}
