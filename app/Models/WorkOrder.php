<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    public function JobType()
    {
        return $this->hasOne(JobType::class, 'id', 'job_type_id');
    }
    public function Customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
    public function Worker()
    {
        return $this->belongsToMany(Worker::class, 'work_order_workers', 'work_order_id', 'worker_id');
    }
    public function Parent()
    {
        return $this->belongsTo(WorkOrder::class, 'parent_id', 'id');
    }
    public function getCustomPaths()
    {
        return [
            [
                'name' => 'work_order_path',
                'column' => 'name',
                'separator' => ' / ',
            ],
        ];
    }
    public function comments()
    {
        return $this->morphMany(Comments::class, 'commentable');
    }
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

}
