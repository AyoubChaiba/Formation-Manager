<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target_groups extends Model
{
    use HasFactory;

    public function Responsibles()
    {
        return $this->belongsTo(Responsibles::class,'responsible_id');
    }

    public function Programs()
    {
        return $this->belongsTo(Programs::class,'program_id');
    }

    public function GetBeneficiaries()
    {
        return $this->hasMany(Beneficiaries::class,'target_group_id');
    }
    public function GetCourses()
    {
        return $this->hasMany(R_CoursesTarget::class,'target_group_id');
    }
}
