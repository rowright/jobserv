<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }
}
