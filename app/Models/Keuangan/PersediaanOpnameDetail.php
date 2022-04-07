<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\ProdukTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersediaanOpnameDetail extends Model
{
    use HasFactory, ProdukTraits;
    protected $table = 'haramain_keuangan.persediaan_opname_detail';
    protected $fillable = [
        'persediaan_opname_id',
        'produk_id',
        'jumlah',
        'harga',
        'sub_total',
    ];

    public function persediaan_opname()
    {
        return $this->belongsTo(PersediaanOpname::class, 'persediaan_opname_id');
    }
}
