<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

}
