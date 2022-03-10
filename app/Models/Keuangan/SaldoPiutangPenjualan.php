<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\CustomerTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoPiutangPenjualan extends Model
{
    use HasFactory, CustomerTraits;
    protected $table = 'saldo_piutang_penjualan';

    protected $fillable = [
        'customer_id',
        'tgl_awal',
        'tgl_akhir',
        'saldo'
    ];
}
