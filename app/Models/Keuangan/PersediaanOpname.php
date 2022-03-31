<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\GudangTraits;
use App\Haramain\Traits\ModelTraits\UserTraits;
use App\Models\Stock\StockOpname;
use App\Models\Stock\StockOpnameDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanOpname extends Model
{
    use HasFactory, GudangTraits, UserTraits;
    protected $table = 'haramain_keuangan.persediaan_opname';
    protected $fillable = [
        'kode',
        'active_cash',
        'kondisi',
        'gudang_id',
        'stock_opname_id',
        'user_id',
        'keterangan',
    ];

    public function stock_opname()
    {
        return $this->belongsTo(StockOpname::class, 'stock_opname_id');
    }

    public function persediaan_opname_detail()
    {
        return $this->hasMany(PersediaanOpnameDetail::class, 'persediaan_opname_id');
    }
}
