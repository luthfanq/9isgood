<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\AkunTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalTransaksi extends Model
{
    use HasFactory, AkunTrait;
    protected $table = 'haramain_keuangan.jurnal_transaksi';
    protected $fillable = [
        'active_cash',
        'jurnal_type',
        'jurnal_id',
        'akun_id',
        'nominal_debet',
        'nominal_kredit',
        'keterangan'
    ];

    public function jurnalable_transaksi(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'jurnal_type', 'jurnal_id');
    }
}
