<?php

namespace App\Http\Livewire\Stoc;

use App\Models\KonfigurasiJurnal;
use App\Models\Master\Produk;
use App\Models\Stock\StockMutasi;
use Livewire\Component;

class StockRusakForm extends Component
{
    public function render()
    {
        return view('livewire.stoc.stock-rusak-form');
    }

    public $mode = 'create', $update=true;
    public $data_detail = [];

    // variabel general
    public $mutasi_id;
    public $gudang_data;
    public $gudang_asal_id, $gudang_tujuan_id;
    public $nomor_surat_jalan;
    public $keterangan;

    // variabel detail
    public $index;
    public $produk_id, $produk_nama, $produk_kode_lokal;
    public $jumlah;

    // variabel jurnal
    public $persediaan_baik_kalimas, $persediaan_baik_perak;
    public $persediaan_rusak;

    public function mount($mutasi_id)
    {
        $this->setJurnal();
        if ($mutasi_id){
            $this->mutasi_id = $mutasi_id;
            $mutasi = StockMutasi::query()->find($mutasi_id);
            $this->gudang_asal_id = $mutasi->gudang_asal_id;
            $this->gudang_tujuan_id = $mutasi->gudang_tujuan_id;
            $this->nomor_surat_jalan = $mutasi->nomor_surat_jalan;
            $this->keterangan = $mutasi->keterangan;

            foreach ($mutasi->stockMutasiDetail as $item) {
                //
            }
        }
    }

    public function setJurnal()
    {
        $this->persediaan_baik_kalimas = KonfigurasiJurnal::query()->find('persediaan_baik_kalimas')->akun_id ?? '';
        $this->persediaan_baik_perak = KonfigurasiJurnal::query()->find('persediaan_baik_perak')->akun_id ?? '';
        $this->persediaan_rusak = KonfigurasiJurnal::query()->find('persediaan_rusak')->akun_id ?? '';
    }

    public function setProduk(Produk $produk)
    {
        $this->produk_id = $produk->id;
        $this->produk_nama = $produk->nama."\n".$produk->cover."-".$produk->kategoriHarga->nama;
        $this->produk_kode_lokal = $produk->kode_lokal;
    }

    public function addLine()
    {
        $this->data_detail[] = [
            'kode_lokal'=>$this->produk_kode_lokal,
            'produk_nama'=>$this->produk_nama,
            'produk_id'=>$this->produk_idm,
            'jumlah'=>$this->jumlah
        ];
        $this->reset([$this->produk_kode_lokal, $this->produk_id, $this->produk_nama, $this->jumlah]);
    }

    public function editLine($index)
    {
        $this->index = $index;
        $this->produk_id = $this->data_detail[$index]['produk_id'];
        $this->produk_nama = $this->data_detail[$index]['produk_nama'];
        $this->produk_kode_lokal = $this->data_detail[$index]['kode_lokal'];
        $this->jumlah = $this->data_detail[$index]['jumlah'];
    }

    public function updateLine()
    {
        $index = $this->index;
        $this->data_detail[$index]['produk_id'] = $this->produk_id;
        $this->data_detail[$index]['produk_nama'] = $this->produk_nama;
        $this->data_detail[$index]['kode_lokal'] = $this->produk_kode_lokal;
        $this->data_detail[$index]['jumlah'] = $this->jumlah;
        $this->reset([$this->produk_kode_lokal, $this->produk_id, $this->produk_nama, $this->jumlah]);
    }

    public function destroyLine($index)
    {
        unset($this->data_detail[$index]);
        $this->data_detail = array_values($this->data_detail);
    }

    protected function validateData()
    {
        $this->validate([
            'mutasi_id'=>'nullable',
            'gudang_asal_id'=>'required',
            'gudang_tujuan_id'=>'required',
            'nomor_surat_jalan'=>'required',
            'keterangan'=>'nullable',
            'data_detail'=>'required',
            'persediaan_baik_kalimas'=>'required',
            'persediaan_baik_perak'=>'required',
            'persediaan_rusak'=>'required'
        ]);
    }


}
