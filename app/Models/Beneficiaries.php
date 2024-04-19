<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaries extends Model
{
    use HasFactory;

    public function TargetGroups()
    {
        return $this->belongsTo(Target_groups::class,'target_group_id');
    }
}
