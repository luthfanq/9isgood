<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\AkunTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeracaSaldoAwalModel extends Model
{
    use HasFactory, AkunTrait;
    protected $table = 'nerasa_saldo_awal';
    protected $fillable = [
        'active_cash',
        'user_id',
        'akun_id',
        'nominal_debet',
        'nominal_kredit',
        'keterangan',
    ];

}
