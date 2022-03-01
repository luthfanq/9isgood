<?php

namespace App\Models\Master;

use App\Haramain\Traits\ModelTraits\KodeTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory, KodeTraits;
    protected $table = 'pegawai';
    protected $fillable = [
        'kode',
        'user_id',
        'nama',
        'gender',
        'jabatan',
        'telepon',
        'alamat',
        'keterangan',
    ];
}
