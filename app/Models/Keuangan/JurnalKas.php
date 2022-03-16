<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalKas extends Model
{
    use HasFactory;
    protected $table = 'jurnal_kas';
    protected $fillable = [
        'kode',
        'type',
        'active_cash',
        'cash_type',
        'cash_id',
        'akun_id',
        'nominal_debet',
        'nominal_kredit',
        'nominal_saldo',
    ];

    public function jurnal_kas()
    {
        return $this->morphTo(__FUNCTION__, 'cash_type', 'cash_id');
    }
}
