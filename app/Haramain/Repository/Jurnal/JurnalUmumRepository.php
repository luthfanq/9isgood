<?php namespace App\Haramain\Repository\Jurnal;

use App\Haramain\Repository\Neraca\NeracaSaldoRepository;
use App\Models\Keuangan\JurnalUmum;

class JurnalUmumRepository
{
    public function kode()
    {
        $query = JurnalUmum::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()){
            return '0001/JU/'.date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/JU/".date('Y');
    }

    public function store(object $data)
    {
        // create jurnal umum baru
        $jurnalUmum = JurnalUmum::query()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>$this->kode(),
            'tujuan'=>$data->tujuan,
            'tgl_jurnal'=>tanggalan_database_format($data->tgl_jurnal, 'd-M-Y'),
            'is_persediaan_awal'=>$data->is_persediaan_awal ?? false,
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
        return $this->storeDetail($data, $jurnalUmum);
    }

    public function update($data)
    {
        // initiate
        $jurnalUmum = JurnalUmum::query()->find($data->jurnal_id);

        // rollback
        if($data->is_persediaan_awal == true){
            foreach ($jurnalUmum->jurnal_transaksi as $item){
                (new NeracaSaldoRepository())->rollback($item);
            }
        }

        // delete jurnal transaksi
        $jurnalUmum->jurnal_transaksi()->delete();

        $jurnalUmum->update([
            'tujuan'=>$data->tujuan,
            'tgl_jurnal'=>tanggalan_database_format($data->tgl_jurnal, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        return $this->storeDetail($data, $jurnalUmum);
    }

    /**
     * @param $data
     * @param \Illuminate\Database\Eloquent\Model|array|null $jurnalUmum
     * @return mixed
     */
    protected function storeDetail($data, \Illuminate\Database\Eloquent\Model|array|null $jurnalUmum): mixed
    {
        foreach ($data->data_detail as $item) {
            // create jurnal transaksi
            $jurnalUmum->jurnal_transaksi()->create([
                'active_cash' => session('ClosedCash'),
                'akun_id' => $item['akun_id'],
                'nominal_debet' => $item['nominal_debet'] ?? null,
                'nominal_kredit' => $item['nominal_kredit'] ?? null,
                'keterangan' => $item['keterangan'] ?? null
            ]);
            // update neraca awal
            if($data->is_persediaan_awal == true){
                (new NeracaSaldoRepository())->update($item);
            }
        }

        return $jurnalUmum->id;
    }

    public function destroy($jurnal_id)
    {
        $jurnalUmum = JurnalUmum::query()->find($jurnal_id);

        // rollback
        foreach ($jurnalUmum->jurnal_transaksi as $item){
            (new NeracaSaldoRepository())->rollback($item);
        }

        // selete jurnal transaksi
        $jurnalUmum->jurnal_transaksi()->delete();
        return $jurnalUmum->delete();
    }
}
