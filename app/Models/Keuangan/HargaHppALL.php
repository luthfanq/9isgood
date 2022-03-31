<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaHppALL extends Model
{
    use HasFactory;
    protected $table = 'haramain_keuangan.harga_hpp_all';
    protected $fillable = [
        'deskripsi',
        'harga',
        'persen',
    ];
}
