<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderWorker extends Model
{
    use HasFactory;

    public function Worker() {
        return $this->belongsTo(Worker::class, 'id', 'worker_id');
    }
    public function WorkOrder() {
        return $this->belongsTo(WorkOrder::class, 'id', 'work_order_id');
    }
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

}
