<?php

namespace App\Http\Livewire\Keuangan;

use App\Haramain\Repository\Persediaan\PersediaanOpnameRepository;
use App\Models\Keuangan\HargaHppALL;
use App\Models\Keuangan\PersediaanAwalTemporary;
use App\Models\Keuangan\PersediaanOpname;
use App\Models\KonfigurasiJurnal;
use App\Models\Master\Gudang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PersediaanOpnameForm extends Component
{
    public function render()
    {
        return view('livewire.keuangan.persediaan-opname-form');
    }

    protected $listeners = [
        'set_produk'=>'setPersediaan'
    ];

    public $update = false, $mode='create';

    public $data_detail = [];
    public $gudang_data = [];

    // var form master
    public $persediaan_opname_id;
    public $kondisi, $tujuan,$gudang_id, $keterangan;

    // var form detail
    public $produk_id, $produk_kode_lokal, $produk_nama, $produk_cover, $produk_harga, $produk_kategori_harga;
    public $harga, $harga_jual, $harga_generate, $jumlah, $sub_total;
    public $hpp_persen, $hpp_rekom;
    public $indexDetail;
    public $total_persediaan;

    // var for jurnal_transaksi
    public $akun_persediaan_awal, $akun_modal_persediaan;

    // url exception
    public $urlConfigHpp, $urlConfigJurnal;

    public function mount($persediaanOpnameId=null)
    {
        $this->gudang_data = Gudang::query()->oldest()->get();
        $this->gudang_id = 1;

        $this->setHppPersen();
        $this->setJurnalTransaksi();
        $this->kondisi = 'baik';

        if ($persediaanOpnameId){
            $this->mode = 'update';
            $persediaanOpname = PersediaanOpname::query()->find($persediaanOpnameId);
            $this->persediaan_opname_id = $persediaanOpname->id;
            $this->kondisi = $persediaanOpname->kondisi;
            $this->gudang_id = $persediaanOpname->gudang_id;
            $this->setGudang();
            $this->tujuan = $persediaanOpname->tujuan;
            $this->keterangan = $persediaanOpname->keterangan;

            //
            foreach ($persediaanOpname->persediaan_opname_detail as $row){
                $this->data_detail[] = [
                    'produk_id'=>$row->produk_id,
                    'kode_lokal'=>$row->produk->kode_lokal,
                    'produk_nama'=>$row->produk->nama,
                    'harga_jual'=>$row->produk->harga,
                    'harga'=>$row->harga,
                    'jumlah'=>$row->jumlah,
                    'sub_total'=>$row->sub_total,
                ];
            }
            $this->total_persediaan = array_sum(array_column($this->data_detail, 'sub_total'));
        }
    }

    public function setGudang()
    {
        $this->emit('setGudang', $this->gudang_id);
    }

    public function setHppPersen()
    {
        // get Harga Hpp
        $getHpp = HargaHppALL::query()->where('deskripsi', 'HPP Internal');
        if ($getHpp->doesntExist()){
            // pop up disable form and must be redirect to config
            session()->flash('setHppPersen', 'Isi Data Config Dulu');
            $this->urlConfigHpp = route('config.hpp');
        }
        $this->hpp_persen = (float) $getHpp->first()->persen;
    }

    // set for jurnal_transaksi
    public function setJurnalTransaksi()
    {
        $configQuery = KonfigurasiJurnal::query();
        $this->akun_persediaan_awal = $configQuery->firstWhere('config', 'akun_persediaan_awal')->akun_id;
        $configQuery = KonfigurasiJurnal::query();
        $this->akun_modal_persediaan = $configQuery->firstWhere('config', 'akun_modal_persediaan')->akun_id;

        if ($this->akun_persediaan_awal == null || $this->akun_modal_persediaan == null){
            // pop up disable form and must be redirect to config jurnal
            session()->flash('setJurnalTransaksi', 'Isi Data Config Dulu');
            $this->urlConfigJurnal = route('config.jurnal');
        }
    }

    /**
     * hpp rekomendasi dari konfigurasi set harga hpp
     */
    public function setGenerateHarga()
    {
        $this->hpp_rekom = $this->harga_jual * $this->hpp_persen;
    }

    public function setHppToHarga()
    {
        $this->harga = $this->hpp_rekom;
        $this->setSubTotal();
    }

    public function setSubTotal()
    {
        $this->sub_total = (int) $this->harga * (int) $this->jumlah;
    }

    public function setPersediaan(PersediaanAwalTemporary $persediaanAwalTemporary)
    {
        $this->produk_id = $persediaanAwalTemporary->produk_id;
        $this->produk_kode_lokal = $persediaanAwalTemporary->produk->kode_lokal;
        $this->produk_nama = $persediaanAwalTemporary->produk->nama."\n".$persediaanAwalTemporary->produk->kategoriHarga->nama."\n".$persediaanAwalTemporary->produk->cover;
        $this->harga_jual = $persediaanAwalTemporary->produk->harga;
        $this->produk_kategori_harga = $persediaanAwalTemporary->produk->kategoriHarga->nama;
        $this->jumlah = $persediaanAwalTemporary->jumlah;
        $this->setGenerateHarga();
    }

    public function addLine()
    {
        // validate
        $this->validate([
            'produk_nama'=>'required',
            'harga'=>'required|integer'
        ]);
        $this->data_detail[] = [
            'produk_id'=>$this->produk_id,
            'kode_lokal'=>$this->produk_kode_lokal,
            'produk_nama'=>$this->produk_nama,
            'harga_jual'=>$this->harga_jual,
            'harga'=>$this->harga,
            'jumlah'=>$this->jumlah,
            'sub_total'=>$this->sub_total,
        ];
        $this->reset(['produk_id', 'produk_nama', 'produk_kode_lokal', 'harga', 'jumlah', 'sub_total', 'hpp_rekom', 'harga_jual']);
    }

    public function editLine($index): void
    {
        $this->update = true;
        $this->indexDetail = $index;
        $this->produk_kode_lokal = $this->data_detail[$index]['kode_lokal'];
        $this->produk_id = $this->data_detail[$index]['produk_id'];
        $this->produk_nama = $this->data_detail[$index]['produk_nama'];
        $this->harga_jual = $this->data_detail[$index]['harga_jual'];
        $this->harga = $this->data_detail[$index]['harga'];
        $this->jumlah = $this->data_detail[$index]['jumlah'];
        $this->sub_total = $this->data_detail[$index]['sub_total'];
        $this->setGenerateHarga();
        $this->setHppToHarga();
        $this->setSubTotal();
    }

    public function updateLine(): void
    {
        // validate
        $index = $this->indexDetail;
        $this->data_detail[$index]['kode_lokal'] = $this->produk_kode_lokal;
        $this->data_detail[$index]['produk_id'] = $this->produk_id;
        $this->data_detail[$index]['produk_nama'] = $this->produk_nama;
        $this->data_detail[$index]['harga'] = $this->harga;
        $this->data_detail[$index]['jumlah'] = $this->jumlah;
        $this->data_detail[$index]['sub_total'] = $this->sub_total;
        $this->update = false;
        $this->reset(['produk_id', 'produk_nama', 'produk_kode_lokal', 'harga', 'jumlah', 'sub_total', 'hpp_rekom', 'harga_jual']);
    }

    public function destroyLine($index): void
    {
        // remove line transaksi
        unset($this->data_detail[$index]);
        $this->data_detail = array_values($this->data_detail);
    }

    public function store()
    {
        $this->total_persediaan = array_sum(array_column($this->data_detail, 'sub_total'));
        $validate = $this->validate([
            'persediaan_opname_id'=>'nullable',
            'kondisi'=>'required',
            'gudang_id'=>'required',
            'tujuan'=>'nullable',
            'total_persediaan'=>'required',
            'keterangan'=>'nullable',
            'akun_persediaan_awal'=>'required',
            'akun_modal_persediaan'=>'required',
            'data_detail'=>'required'
        ]);
        \DB::beginTransaction();
        try {
            $store = (new PersediaanOpnameRepository())->store((object)$validate);
            \DB::commit();
            return redirect()->route('persediaan.opname');
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
    }

    public function update(){
        $this->total_persediaan = array_sum(array_column($this->data_detail, 'sub_total'));
        $validate = $this->validate([
            'persediaan_opname_id'=>'required',
            'kondisi'=>'required',
            'gudang_id'=>'required',
            'tujuan'=>'nullable',
            'total_persediaan'=>'required',
            'keterangan'=>'nullable',
            'akun_persediaan_awal'=>'required',
            'akun_modal_persediaan'=>'required',
            'data_detail'=>'required'
        ]);
        \DB::beginTransaction();
        try {
            $store = (new PersediaanOpnameRepository())->update((object)$validate);
            \DB::commit();
            return redirect()->route('persediaan.opname');
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
    }
}
