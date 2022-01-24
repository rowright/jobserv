<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function WorkOrder() {
        return $this->hasMany(WorkOrder::class, 'customer_id', 'id');
    }
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

}
