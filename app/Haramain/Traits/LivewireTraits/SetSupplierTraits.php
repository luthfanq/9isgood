<?php namespace App\Haramain\Traits\LivewireTraits;

use App\Models\Master\Supplier;

trait SetSupplierTraits
{
    public $supplier_id, $supplierNama;

    public function setSupplier(Supplier $supplier)
    {
        $this->supplier_id = $supplier->id;
        $this->supplierNama = $supplier->nama;
    }
}
