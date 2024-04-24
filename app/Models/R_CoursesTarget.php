<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class R_CoursesTarget extends Model
{
    use HasFactory;

    public function getGroup()
    {
        return $this->belongsTo(Target_groups::class,'target_group_id');
    }
    public function GetCourses()
    {
        return $this->belongsTo(Courses::class,'course_id');
    }

}
