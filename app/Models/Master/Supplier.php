<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = [
        'supplier_jenis_id',
        'nama',
        'alamat',
        'telepon',
        'npwp',
        'email',
        'keterangan',
    ];

    public function jenisSupplier()
    {
        return $this->belongsTo(SupplierJenis::class, 'supplier_jenis_id');
    }
}
