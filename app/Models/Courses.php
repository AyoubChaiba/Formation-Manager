<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    public function TargetGroups()
    {
        return $this->hasMany(R_CoursesTarget::class,'course_id');
    }

    public function Programs()
    {
        return $this->belongsTo(Programs::class,'program_id');
    }
}
