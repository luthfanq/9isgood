<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\KodeTraits;
use App\Haramain\Traits\ModelTraits\UserTraits;
use App\Models\Master\Gudang;
use App\Models\Stock\StockMutasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPersediaanMutasi extends Model
{
    use HasFactory, UserTraits, KodeTraits;
    protected $table = 'haramain_keuangan.jurnal_persediaan_mutasi';
    protected $fillable = [
        'active_cash',
        'kode',
        'gudang_asal_id',
        'gudang_tujuan_id',
        'stock_mutasi_id',
        'jenis',
        'user_id',
        'keterangan',
    ];

    public function persediaanTransaksi()
    {
        return $this->morphMany(PersediaanTransaksi::class, 'persediaanable_transaksi', 'persediaan_type', 'persediaan_id');
    }

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'gudang_sal_id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function stockMutasi()
    {
        return $this->belongsTo(StockMutasi::class, 'stock_mutasi_id');
    }

    public function jurnalTransaksi()
    {
        return $this->morphMany(JurnalTransaksi::class, 'jurnalable_transaksi', 'jurnal_type', 'jurnal_id');
    }
}
