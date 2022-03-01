<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierJenis extends Model
{
    use HasFactory;
    protected $table = 'supplier_jenis';
    protected $fillable = [
        'jenis',
        'keterangan'
    ];
}
