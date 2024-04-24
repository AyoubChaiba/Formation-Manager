<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_beneficiaries extends Model
{
    use HasFactory;
    public function GetBeneficiarie()
    {
        return $this->belongsTo(Beneficiaries::class,'beneficiarie_id');
    }
}
