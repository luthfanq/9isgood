<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\CustomerTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPiutangPegawaiDetail extends Model
{
    use HasFactory;
    protected $table = 'jurnal_piutang_pegawai_detail';

    protected $fillable = [
        'jurnal_piutang_pegawai_id',
        'nominal_debet',
        'nominal_kredit',
        'nominal_saldo',
    ];
    
    public function jurnalPiutangPegawai()
    {
        return $this->belongsTo(JurnalPiutangPegawai::class,'jurnal_piutang_pegawai_id');
    }
}