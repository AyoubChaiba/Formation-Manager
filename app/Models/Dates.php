<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    use HasFactory;

    public function GetPrograms()
    {
        return $this->hasMany(Programs::class,'date_id');
    }
}
