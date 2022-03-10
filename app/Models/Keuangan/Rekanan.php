<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\KodeTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekanan extends Model
{
    use HasFactory, KodeTraits;
    protected $table = 'person_relation';
    protected $fillable = [
        'kode',
        'nama',
        'telepon',
        'alamat',
        'keterangan',
    ];
}
