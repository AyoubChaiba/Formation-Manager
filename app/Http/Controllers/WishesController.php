<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaries;
use App\Models\Target_groups;
use App\Models\Wishes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WishesController extends Controller
{
    public function index(Request $request) {
        $id = $request->id ;
        $ppr = $request->ppr ;
        $targetGroup = Target_groups::with('GetCourses')->find($id);
        $beneficiarie = Beneficiaries::where('PPR', $ppr)->first();
        return view('admin.pages.Contact.wishPage', compact('targetGroup','beneficiarie'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "beneficiarie_id" => "required",
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
            $wish->save();

            Session::flash('success', 'The wish was successfully added.');
            // return response()->json([
            //     'status' => true,
            //     'message' => 'Wish added successfully',
            // ]);
            // return redirect()->route('');
        } else {
            // return response()->json([
            //     'status' => false,
            //     'errors' => $validator->errors()
            // ]);
        }
    }
}
