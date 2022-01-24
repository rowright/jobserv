<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

}