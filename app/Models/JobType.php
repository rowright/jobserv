<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    public function Children()
    {
        return $this->hasMany(JobType::class, 'parent_id', 'id');
    }
    public function getCustomPaths()
    {
        return [
            [
                'name' => 'name_path',
                'column' => 'name',
                'separator' => ' / ',
            ],
        ];
    }
    public function scopeTenant($query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

}
