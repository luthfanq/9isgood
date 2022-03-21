<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'jurnal_penjualan_detail';
    protected $fillable = [
        'jurnal_penjualan_id',
        'penjualan_id',
        'total_penjualan',
        'akun_biaya_1',
        'total_biaya_1',
        'akun_biaya_2',
        'total_biaya_2',
        'akun_ppn',
        'total_ppn',
    ];

    public function jurnalPenjualanId()
    {
        return $this->belongsTo(JurnalPenjualan::class, 'jurnal_penjualan_id');
    }

    public function akunBiaya1()
    {
        return $this->belongsTo(Akun::class, 'akun_biaya_1');
    }

    public function akunBiaya2()
    {
        return $this->belongsTo(Akun::class, 'akun_biaya_2');
    }

    public function akunPpn()
    {
        return $this->belongsTo(Akun::class, 'akun_ppn');
    }
}
