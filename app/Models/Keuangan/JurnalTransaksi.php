<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalTransaksi extends Model
{
    use HasFactory;
    protected $table = 'jurnal_transaksi';
    protected $fillable = [
        'jurnal_type',
        'jurnal_id',
        'akun_id',
        'nominal_debet',
        'nominal_kredit',
        'keterangan'
    ];

    public function jurnalable_transaksi()
    {
        return $this->morphTo(__FUNCTION__, 'jurnal_type', 'jurnal_id');
    }
}
