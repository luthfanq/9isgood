<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\Persediaan;

class PersediaanJenisKeluarRepo
{
    protected $closedCash;

    public function __construct()
    {
        $this->closedCash = session('ClosedCash');
    }

    /**
     * mengembalikan nilai untuk dipakai dalam persediaan transaksi keluar
     * metode FIFO (algoritma FIFO)
     * @param object $data
     * @return array|int
     */
    public function store(object $data, $gudang, $kondisi): int|array
    {
        // initiate
        $data_produk = [];
        // get single data by oldest one
        $query = Persediaan::query()
            ->where('active_cash', $this->closedCash)
            ->where('jenis', $kondisi)
            ->where('gudang', $gudang)
            ->where('produk_id', $data->produk_id)
            ->whereNotIn('stock_saldo', 0)
            ->oldest();

        $count = $query->count();
        $sum = $query->sum('stock_saldo');

        // kondisi di mana data pada persediaan tidak ada (semoga hal ini tidak pernah kejadian)

        // keadaan di mana stock_keluar tidak sesuai dengan stock yg ada
        if ($data->jumlah > $sum){
            for ($i = $count; $i>=0; $i--){
                $jumlahStock = $query->first()->stock_saldo;
                // keadaan selesai
                if ($i = 1){
                    $data_produk [] = (object) [
                        'produk_id'=>$data->produk_id,
                        'harga'=>$query->harga,
                        'jumlah'=>$i,
                    ];
                    $query->increment('stock_keluar', $i);
                    return $query->decrement('stock_saldo', $i);
                }
                $data_produk [] = (object) [
                    'produk_id'=>$data->produk_id,
                    'harga'=>$query->harga,
                    'jumlah'=>$jumlahStock,
                ];
                // tambah stock keluar
                $query->increment('stock_keluar', $jumlahStock);
                // kurangi saldo
                $query->decrement('stock_saldo', $jumlahStock);
                // refresh query
                $query->refresh();
            }
        }

        // insert stock sesuai dengan jumlah
        for($i = $data->jumlah; $i >= 0;){
            $jumlahStock = $query->first()->stock_saldo;
            if ($i < $jumlahStock){
                $data_produk [] = (object) [
                    'produk_id'=>$data->produk_id,
                    'harga'=>$query->harga,
                    'jumlah'=>$i,
                ];
                $query->increment('stock_keluar', $i);
                return $query->decrement('stock_saldo', $i);
            }
            $data_produk [] = (object) [
                'produk_id'=>$data->produk_id,
                'harga'=>$query->harga,
                'jumlah'=>$jumlahStock,
            ];
            $i = $i - $jumlahStock;
            // tambah stock keluar
            $query->increment('stock_keluar', $jumlahStock);
            // kurangi saldo
            $query->decrement('stock_saldo', $jumlahStock);
            // refresh query
            $query->refresh();
        }
        return $data_produk;
    }

    /**
     * mengembalikan data pada persediaan sesuai data dari detail persediaan transaksi
     * @param object $data
     * @param $gudang
     * @param $kondisi
     * @return int
     */
    public function rollback(object $data, $gudang, $kondisi)
    {
        // mengembalikan nilai dari persediaan_transaksi
        $query = Persediaan::query()
            ->where('active_cash', $this->closedCash)
            ->where('jenis', $kondisi)
            ->where('gudang', $gudang)
            ->where('produk_id', $data->produk_id)
            ->where('harga', $data->harga)
            ->oldest();

        $query->decrement('stock_keluar', $data->jumlah);
        return $query->increment('stock_saldo', $data->jumlah);
    }
}
