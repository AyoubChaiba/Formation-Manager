<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use App\Models\TempDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DatesController extends Controller
{
    public function index() {
        $dates = Dates::with('GetPrograms')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.dates.list', compact('dates'));
    }
    public function create() {
        return view('admin.pages.dates.create');
    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            "year" => "required|unique:dates,year",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        if ($validator->passes()) {
            $date = new Dates();
            $date->year = $request->year;
            $date->start_date = $request->start_date;
            $date->end_date = $request->end_date;
            $date->save();

            Session::flash('success', 'The date was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Date added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id) {
        $date = Dates::find($id);
        return view('admin.pages.dates.edit', compact('date'));
    }
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "year" => "required",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        if ($validator->passes()) {
            $date = Dates::find($id);
            $date->year = $request->year;
            $date->start_date = $request->start_date;
            $date->end_date = $request->end_date;
            $date->save();
            Session::flash('success', 'The date was successfully updated.');
            return response()->json([
                'status' => true,
                'message' => 'Date updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete ($id) {
        $date = Dates::find($id);
        $date->delete();

        Session::flash('success', 'The date was successfully deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Date deleted successfully',
        ]);
    }
}
