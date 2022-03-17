<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirPenjualanDetail extends Model
{
    use HasFactory;
    protected $table = 'kasir_penjualan_detail';
    protected $fillable = [
        'kasir_penjualan_id',
        'penjualan_id'
    ];

    public function kasir_penjualan()
    {
        return $this->belongsTo(KasirPenjualan::class, 'kasir_penjualan_id');
    }
}
