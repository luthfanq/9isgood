<?php

namespace App\Models\Penjualan;

use App\Models\Keuangan\JurnalPenjualan;
use App\Models\Keuangan\PersediaanTransaksi;
use App\Haramain\Traits\ModelTraits\{CustomerTraits, GudangTraits, KodeTraits, StockKeluarTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory, KodeTraits, CustomerTraits, GudangTraits, UserTraits, StockKeluarTraits;
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

    public function jurnal_penjualan()
    {
        return $this->hasOne(JurnalPenjualan::class, 'penjualan_id');
    }

    public function persediaan_transaksi()
    {
        return $this->morphOne(PersediaanTransaksi::class, 'persediaanable_transaksi', 'persediaan_type', 'persediaan_id');
    }
}
