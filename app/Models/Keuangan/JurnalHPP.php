<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalHPP extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'hpp';
    protected $fillable = [
        'active_cash',
        'type', // debet/kredit
        'stock_type',
        'stock_id',
        'nominal_debet',
        'nominal_kredit',
    ];

    public function stockable_hpp()
    {
        return $this->morphTo(__FUNCTION__, 'stock_type', 'stock_id');
    }
}
