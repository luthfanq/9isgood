<?php

namespace App\Http\Livewire\Z;

use App\Models\Penjualan\Penjualan;
use App\Models\Penjualan\PenjualanRetur;
use App\Models\Purchase\Pembelian;
use App\Models\Purchase\PembelianRetur;
use App\Models\Stock\StockOpname;
use Livewire\Component;

class Tester extends Component
{
    public $stockData, $produk_id;
    public function mount($produk_id)
    {
        $this->produk_id = $produk_id;
        $this->stockData = $this->queryMe();
    }

    public function queryMe()
    {
        return \DB::select(\DB::raw('
                select
                penjualan.kode as kode, null as stock_masuk, stock_keluar_detail.jumlah as stock_keluar, penjualan.tgl_nota as tanggal,
                produk.nama as nama, customer.nama as nama_keterangan
                from penjualan
                right join customer
                    on penjualan.customer_id = customer.id
                right join stock_keluar
                on penjualan.id = stock_keluar.stockable_keluar_id
                right join stock_keluar_detail
                on stock_keluar_detail.stock_keluar_id = stock_keluar.id
                right join produk
                on stock_keluar_detail.produk_id = produk.id
                where penjualan.active_cash = "'.session('ClosedCash').'"
                and stock_keluar_detail.produk_id = "'.$this->produk_id.'"

                union all

                select
                stock_opname.kode as kode, stock_opname_detail.jumlah as stock_masuk, null as stock_keluar, stock_opname.tgl_input as tanggal,
                produk.nama as nama, pegawai.nama as nama_keterangan
                from stock_opname
                right join pegawai
                on stock_opname.pegawai_id = pegawai.id
                right join stock_opname_detail
                on stock_opname_detail.stock_opname_id = stock_opname.id
                right join produk
                on stock_opname_detail.produk_id = produk.id
                where stock_opname.active_cash = "'.session('ClosedCash').'"
                and stock_opname_detail.produk_id = "'.$this->produk_id.'"

                order by tanggal ASC
        '));
    }

    public function render()
    {
        return view('livewire.z.tester');
    }
}
