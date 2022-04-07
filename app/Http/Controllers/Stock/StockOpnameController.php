<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Stock\StockInventory;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function reportStockByProduk()
    {
        $data = StockInventory::query()
            ->where('active_cash', session('ClosedCash'))
            ->join('produk', 'produk.id', '=', 'stock_inventory.produk_id')
            ->orderBy('produk.nama', 'ASC')
            ->get();

        $pdf = \PDF::loadView('pages.ReportStockOpname', [
            'dataStockOpname'=>$data
        ]);
        $options = [
            'margin-top'    => 5,
            'margin-right'  => 5,
            'margin-bottom' => 5,
            'margin-left'   => 5,
        ];
        $pdf->setPaper('a4');
        $pdf->setOptions($options);
        return $pdf->inline('invoice.pdf');
    }
}
