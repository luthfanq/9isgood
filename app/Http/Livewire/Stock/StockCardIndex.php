<?php

namespace App\Http\Livewire\Stock;

use App\Models\Master\Gudang;
use Livewire\Component;

class StockCardIndex extends Component
{
    public $produk_id, $queryData;
    public $gudang_id, $gudang;

    public function mount($produk_id, $gudang_id=null)
    {
        $this->produk_id = $produk_id;
        if ($gudang_id){
            $this->gudang = Gudang::query()->find($gudang_id)->nama;
            $this->gudang_id = $gudang_id;
            $this->queryData = $this->queryMeGudang();
        } else {
            $this->queryData = $this->queryMe();
        }
    }

    public function queryMeGudang()
    {
        return \DB::select(\DB::raw(
            "SELECT produk.nama AS nama, pj.kode, produk_id, jumlah AS jumlah_keluar, NULL AS jumlah_masuk,tgl_keluar AS tanggal
                    FROM stock_keluar sk
                    RIGHT JOIN stock_keluar_detail skd
                    ON sk.id = skd.stock_keluar_id
                    RIGHT JOIN produk
                    ON produk.id = skd.produk_id
                    RIGHT JOIN penjualan pj
                    ON pj.id = sk.stockable_keluar_id
                    WHERE produk_id = '".$this->produk_id."'
                    AND sk.active_cash = '".session('ClosedCash')."'
                    AND sk.gudang_id = '".$this->gudang_id."'

                    UNION ALL

                    SELECT produk.nama AS nama, sm.kode, produk_id, NULL AS jumlah_keluar, jumlah AS jumlah_masuk,tgl_masuk AS tanggal
                    FROM stock_masuk sm
                    RIGHT JOIN stock_masuk_detail smd
                    ON sm.id = smd.stock_masuk_id
                    RIGHT JOIN produk
                    ON produk.id = smd.produk_id
                    WHERE produk_id = '".$this->produk_id."'
                    AND active_cash = '".session('ClosedCash')."'
                    AND gudang_id = '".$this->gudang_id."'


                    UNION ALL

                    SELECT produk.nama AS nama, so.kode, produk_id, NULL AS jumlah_keluar, jumlah AS jumlah_masuk, tgl_input AS tanggal
                    FROM stock_opname so
                    RIGHT JOIN stock_opname_detail sod
                    ON sod.stock_opname_id = so.id
                    RIGHT JOIN produk
                    ON produk.id = sod.produk_id
                    WHERE produk_id = '".$this->produk_id."'
                    AND active_cash = '".session('ClosedCash')."'
                    AND gudang_id = '".$this->gudang_id."'

                    ORDER BY tanggal ASC "
        ));
    }

    public function queryMe()
    {
        return \DB::select(\DB::raw(
            "SELECT produk.nama AS nama, pj.kode, produk_id, jumlah AS jumlah_keluar, NULL AS jumlah_masuk,tgl_keluar AS tanggal
                    FROM stock_keluar sk
                    RIGHT JOIN stock_keluar_detail skd
                    ON sk.id = skd.stock_keluar_id
                    RIGHT JOIN produk
                    ON produk.id = skd.produk_id
                    RIGHT JOIN penjualan pj
                    ON pj.id = sk.stockable_keluar_id
                    WHERE produk_id = '".$this->produk_id."'
                    AND sk.active_cash = '".session('ClosedCash')."'

                    UNION ALL

                    SELECT produk.nama AS nama, sm.kode, produk_id, NULL AS jumlah_keluar, jumlah AS jumlah_masuk,tgl_masuk AS tanggal
                    FROM stock_masuk sm
                    RIGHT JOIN stock_masuk_detail smd
                    ON sm.id = smd.stock_masuk_id
                    RIGHT JOIN produk
                    ON produk.id = smd.produk_id
                    WHERE produk_id = '".$this->produk_id."'
                    AND active_cash = '".session('ClosedCash')."'


                    UNION ALL

                    SELECT produk.nama AS nama, so.kode, produk_id, NULL AS jumlah_keluar, jumlah AS jumlah_masuk, tgl_input AS tanggal
                    FROM stock_opname so
                    RIGHT JOIN stock_opname_detail sod
                    ON sod.stock_opname_id = so.id
                    RIGHT JOIN produk
                    ON produk.id = sod.produk_id
                    WHERE produk_id = '".$this->produk_id."'
                    AND active_cash = '".session('ClosedCash')."'

                    ORDER BY tanggal ASC "
        ));
    }

    public function render()
    {
        return view('livewire.stock.stock-card-index', [
            //'produk_id'=>$this->produk_id
        ]);
    }
}
