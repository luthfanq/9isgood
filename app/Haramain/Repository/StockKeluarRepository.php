<?php namespace App\Haramain\Repository;

use App\Models\Stock\StockKeluar;

class StockKeluarRepository implements TransaksiRepositoryInterface
{
    //
    public static function kode($kondisi='baik'): ?string
    {
        // query
        $query = StockKeluar::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $kondisi)
            ->latest('kode');

        $kodeKondisi = ($kondisi == 'baik') ? 'SK' : 'SKR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kodeKondisi}/".date('Y');
        }

        $num = (int) $query->first()->last_num_trans + 1;
        return sprintf("%04s", $num)."/{$kodeKondisi}/".date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        // TODO: Implement create() method.
    }

    public static function update(object $data, array $detail): ?string
    {
        // TODO: Implement update() method.
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }
}
