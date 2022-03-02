<?php

namespace App\Haramain\Traits\LivewireTraits;

trait ResetFormTraits
{
    public function resetForm()
    {
        $this->reset($this->resetForm);
        $this->resetValidation();
        $this->resetErrorBag();
    }
}
