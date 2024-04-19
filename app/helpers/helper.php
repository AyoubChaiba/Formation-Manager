<?php

use App\Models\Dates;
use App\Models\TempDate;

    function getDates() {
        return Dates::orderBy('created_at','DESC')->get();
    }
    function tempData() {
        if (empty(TempDate::find(1))) {
            $date = new TempDate();
            $date->year = date('Y');
            $date->save();
        }
        return TempDate::find(1) ;
    }

