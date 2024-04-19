<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_target_groups extends Model
{
    use HasFactory;

    public function Programs()
    {
        return $this->belongsTo(Programs::class,'program_id');
    }
    public function TargetGroups()
    {
        return $this->belongsTo(Target_groups::class,'target_group_id');
    }
    public function GetBeneficiaries()
    {
        return $this->hasMany(Contact_beneficiaries::class,'contact_id');
    }
}
