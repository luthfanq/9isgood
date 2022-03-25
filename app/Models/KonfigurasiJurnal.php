<?php

namespace App\Models;

use App\Haramain\Traits\ModelTraits\AkunTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiJurnal extends Model
{
    use HasFactory, AkunTrait;
    protected $connection = 'mysql2';
    protected $table = 'konfigurasi_jurnal';
    protected $primaryKey = 'config';
    protected $keyType= 'string';
    protected $fillable = [
        'akun_id', 'keterangan'
    ];
}
