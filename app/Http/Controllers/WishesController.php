<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaries;
use App\Models\Contact_beneficiaries;
use App\Models\R_CoursesTarget;
use App\Models\Target_groups;
use App\Models\Wishes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WishesController extends Controller
{
    public function index(Request $request) {
        $beneficiarie = Beneficiaries::where('PPR', $request->ppr)->first();
        $courses = R_CoursesTarget::with('GetCourses')->where("target_group_id",$beneficiarie->target_group_id)->get();
        $contact_beneficiarie_id = $request->id;
        return view('admin.pages.Contact.wishPage', compact('beneficiarie','courses','contact_beneficiarie_id'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "beneficiarie_id" => "required",
            "contact_beneficiarie_id" => "required",
            "course_id" => "required",
            "date" => "required",
            "time" => "required",
        ]);

        if ($validator->passes()) {
            $wish = new Wishes();
            $wish->beneficiarie_id = $request->beneficiarie_id;
            $wish->course_id = $request->course_id;
            $wish->date = $request->date;
            $wish->time = $request->time;
            $wish->contact_beneficiarie_id = $request->contact_beneficiarie_id;
            $wish->save();
            Contact_beneficiaries::where("beneficiarie_id",$request->beneficiarie_id)->update(['status' => 1]);
            return redirect()->back()->with('session','The wish was successfully added.');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
}
