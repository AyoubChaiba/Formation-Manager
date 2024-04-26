<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;

    public function date()
    {
        return $this->belongsTo(Dates::class);
    }
    public function GetCourses()
    {
        return $this->hasMany(Courses::class,'program_id');
    }
    public function GetTargetgroups() {
        return $this->hasMany(Target_groups::class,'program_id');
    }
}
