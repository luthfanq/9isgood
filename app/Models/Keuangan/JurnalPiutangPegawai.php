<?php

namespace App\Models\Keuangan;

use App\Haramain\Traits\ModelTraits\{PegawaiTraits, UserTraits};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalPiutangPegawai extends Model
{
    use HasFactory, PegawaiTraits, UserTraits;
    protected $table = 'jurnal_piutang_pegawai';
    protected $fillable = [
        'active_cash',
        'kode',
        'pegawai_id',
        'tgl_piutang',
        'status',
        'nominal',
        'user_id',
        'keterangan',
    ];
    
    public function jurnalPiutangPegawaiDetail()
    {
        return $this->hasMany(JurnalPiutangPegawaiDetail::class, 'jurnal_piutang_pegawai_id');
    }
    
    public function jurnal_transaksi()
    {
        return $this->morphMany(JurnalTransaksi::class, 'jurnalable_transaksi', 'jurnal_type', 'jurnal_id');
    }

}