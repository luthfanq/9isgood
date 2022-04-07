<?php namespace App\Haramain\Repository\Generator;

use App\Haramain\Repository\Persediaan\PersediaanAwalTempRepo;
use App\Models\Stock\StockOpname;

class GeneratePersediaanAwalTempRepo
{
    public function generate()
    {
        $persediaanAwalTemp = new PersediaanAwalTempRepo();

        // ambil semua stock opname
        $stockOpname = StockOpname::query()
            ->where('active_cash', session('ClosedCash'))
            ->get();

        foreach ($stockOpname as $row){
            // detail stock opname
            $stockDetail = $row->stockOpnameDetail;

            foreach ($stockDetail as $item)
            {
                // ditambahkan pada persediaan awal temporary
                $persediaanAwalTemp->updateIncrement($row, $item);
            }
        }
    }
}
