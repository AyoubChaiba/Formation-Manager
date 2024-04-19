<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\TempDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TempDateController extends Controller
{
    public function index(Request $request) {
        if (!empty($request->date_id)) {
            $date = Dates::find($request->date_id);
            if (!empty($date)) {
                $tempDate = TempDate::find(1);
                if (!empty($tempDate)) {
                    $tempDate->year = $date->year;
                    $tempDate->save();
                    return redirect()->back();
                } else {
                    Session::flash('error', 'Temp date not found.');
                    return redirect()->back();
                }
            } else {
                Session::flash('error', 'Date not found.');
                return redirect()->back();
            }
        }
    }
}
