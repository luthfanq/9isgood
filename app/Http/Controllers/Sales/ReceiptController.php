<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\Penjualan;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function printDotmatrix(Penjualan $penjualan)
    {
        $dataPenjualan = [
            'penjualanId' => $penjualan->kode,
            'namaCustomer' => $penjualan->customer->nama,
            'addr_cust' => $penjualan->customer->alamat,
            'tgl_nota' => tanggalan_format($penjualan->tgl_nota),
            'tgl_tempo' => ( strtotime($penjualan->tgl_tempo) > 0) ? tanggalan_format($penjualan->tgl_tempo) : '',
            'status_bayar' => $penjualan->jenis_bayar,
            'sudahBayar' => $penjualan->status_bayar,
            'total_jumlah' => $penjualan->total_jumlah,
            'ppn' => $penjualan->ppn,
            'biaya_lain' => $penjualan->biaya_lain,
            'total_bayar' => $penjualan->total_bayar,
            'penket' => $penjualan->keterangan,
            'print' => $penjualan->print,
        ];
        return view('pages.Receipt.SalesReceipt', [
            'dataUtama'=>json_encode($dataPenjualan),
            'dataDetail'=>$penjualan->penjualanDetail()->with(['produk', 'produk.kategoriHarga'])->get(),
        ]);
    }
}
