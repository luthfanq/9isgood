<?php

namespace App\Models\Purchase;

use App\Models\Keuangan\HutangPembelian;
use App\Models\Keuangan\PersediaanTransaksi;
use App\Haramain\Traits\ModelTraits\{JurnalTransaksiTraits,
    KodeTraits,
    StockKeluarTraits,
    SupplierTraits,
    GudangTraits,
    UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianRetur extends Model
{
    use HasFactory, KodeTraits, SupplierTraits, GudangTraits, UserTraits, StockKeluarTraits, JurnalTransaksiTraits;
    protected $table = 'pembelian_retur';
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

    public function returDetail()
    {
        return $this->hasMany(PembelianReturDetail::class, 'pembelian_retur_id');
    }

    public function persediaan_transaksi()
    {
        return $this->morphOne(PersediaanTransaksi::class, 'persediaanable_transaksi', 'persediaan_type', 'persediaan_id');
    }

    public function hutang_pembelian()
    {
        return $this->morphOne(HutangPembelian::class, 'hutang_pembelian_morph', 'pembelian_type', 'pembelian_id');
    }
}
