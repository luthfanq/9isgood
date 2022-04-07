<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\PersediaanOpname;

class PersediaanOpnameRepository
{
    public function kode($kondisi): string
    {
        $query = PersediaanOpname::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kode = ($kondisi == 'baik') ? 'POB' : 'POR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kode}/".date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/{$kode}/".date('Y');
    }

    public function store($data)
    {
        // initiate
        $field = 'stock_opname';
        // simpan persediaan opname
        $persediaanOpname = PersediaanOpname::query()->create([
            'kode'=>$this->kode($data->kondisi),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang,
            'stock_opname_id'=>$data->stock_opname_id ?? null,
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // foreach for detail
        foreach ($data->data_detail as $row){
            // simpan persediaan opname detail
            $persediaanOpname->persediaan_opname_detail()->create([
                'produk_id'=>$row['produk_harga'],
                'jumlah'=>$row['jumlah'],
                'harga'=>$row['harga'],
                'sub_total'=>$row['sub_total'],
            ]);
            // update persediaan untuk masing-masing detail
            (new PersediaanRepository())->update($persediaanOpname, $row, $field);
        }
        // update neraca saldo awal
        // buat jurnal transaksi
        $jurnalTransaksi = $persediaanOpname->jurnal_transaksi();
        // debet pada persediaan-awal (konfigurasi akun persediaan awal)
        $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->akun_persediaan_awal,
            'nominal_debet'=>$data->total_persediaan,
            'nominal_kredit'=>null,
            'keterangan'=>$data->keterangan
        ]);
        // kredit pada modal pemilik (konfigurasi akun modal pemilik)
        $jurnalTransaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->modal_persediaan,
            'nominal_debet'=>null,
            'nominal_kredit'=>$data->total_persediaan,
            'keterangan'=>$data->keterangan
        ]);
    }
}
