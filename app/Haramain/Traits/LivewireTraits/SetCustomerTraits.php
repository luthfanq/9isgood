<?php namespace App\Haramain\Traits\LivewireTraits;

use App\Models\Master\Customer;

trait SetCustomerTraits
{
    public $customer_id, $customer_nama;

    public function setCustomer(Customer $customer): void
    {
        $this->customer_id = $customer->id;
        $this->customer_nama = $customer->nama;
    }
}
