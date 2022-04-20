<?php

namespace App\Http\Controllers\Penjualan;

use App\Haramain\Repository\Penjualan\PenjualanPureRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportPenjualanController extends Controller
{
    public $penjualanRepo;

    public function __construct()
    {
        $this->penjualanRepo = new PenjualanPureRepo();
    }

    public function index()
    {
        //
    }

    public function reportByDate($tglAwal, $tglAkhir)
    {
        //
    }

    public function reportByPeriodic($active_cash)
    {
        //
    }

    public function reportByProduk($produk_id)
    {
        //
    }
}
