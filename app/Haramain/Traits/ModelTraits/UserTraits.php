<?php

namespace App\Haramain\Traits\ModelTraits;

use App\Models\User;

trait UserTraits
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
