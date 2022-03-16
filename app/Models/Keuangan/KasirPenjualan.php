<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirPenjualan extends Model
{
    use HasFactory;
    protected $table = 'kasir_penjualan';
    protected $fillable = [
        'customer_id',
        'total_nota',
        'total_tunai',
        'total_piutang',
        'user_id'
    ];

    public function kasir_penjualan_detail()
    {
        return $this->hasMany(KasirPenjualanDetail::class, 'kasir_penjualan_id');
    }

    public function jurnal_kas()
    {
        return $this->morphMany(JurnalKas::class, 'jurnal_kas', 'cash_type', 'cash_id');
    }
}
