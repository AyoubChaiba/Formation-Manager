<?php

namespace App\Http\Controllers;

use App\Models\Responsibles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ResponsiblesController extends Controller
{

    public function index() {
        $responsible = Responsibles::paginate(10);
        return view('admin.pages.responsibles.list', compact('responsible'));
    }
    public function create() {
        return view('admin.pages.responsibles.create');
    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required|unique:responsibles,email",
            "first_name" => "required",
            "last_name" => "required",
            "phone_number" => "required|unique:responsibles,phone_number",
        ]);

        if ($validator->passes()) {
            $responsible = new Responsibles();
            $responsible->email = $request->email;
            $responsible->first_name = $request->first_name;
            $responsible->last_name = $request->last_name;
            $responsible->phone_number = $request->phone_number;
            $responsible->status = $request->status;
            $responsible->save();

            Session::flash('success', 'The responsible was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Responsible added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id) {
        $responsible = Responsibles::find($id);
        return view('admin.pages.responsibles.edit', compact('responsible'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "email" => "required|unique:responsibles,email," . $request->id,
            "first_name" => "required",
            "last_name" => "required",
            "phone_number" => "required|unique:responsibles,phone_number," . $request->id,
        ]);

        if ($validator->passes()) {
            $responsible = Responsibles::find($id);
            $responsible->email = $request->email;
            $responsible->first_name = $request->first_name;
            $responsible->last_name = $request->last_name;
            $responsible->phone_number = $request->phone_number;
            $responsible->status = $request->status;
            $responsible->save();

            Session::flash('success', 'The responsible was successfully updated.');
            return response()->json([
                'status' => true,
                'message' => 'Responsible updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete ($id) {
        $responsible = Responsibles::find($id);
        $responsible->delete();

        Session::flash('success', 'The responsible was successfully deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Responsible deleted successfully',
        ]);
    }
}
