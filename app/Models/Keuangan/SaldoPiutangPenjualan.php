<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\CustomerTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoPiutangPenjualan extends Model
{
    use HasFactory, CustomerTraits;

    protected $connection = 'mysql2';

    protected $table = 'saldo_piutang_penjualan';
    public $incrementing = false;
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'saldo'
    ];

    public function piutang_penjualan()
    {
        return $this->hasMany(PiutangPenjualan::class, 'saldo_piutang_penjualan', 'customer_id');
    }
}
