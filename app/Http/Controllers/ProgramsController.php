<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProgramsController extends Controller
{
    public function index() {
        $programs = Programs::with('date')->with('GetCourses')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.programs.list', compact('programs'));
    }
    public function create() {
        return view('admin.pages.programs.create');
    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            "date_id" => "required",
            "domaine" => "required",
        ]);

        if ($validator->passes()) {
            $program = new Programs();
            $program->date_id = $request->date_id;
            $program->domaine = $request->domaine;
            $program->save();

            Session::flash('success', 'The program was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Program added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id) {
        $program = Programs::find($id);
        return view('admin.pages.programs.edit', compact('program'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "date_id" => "required",
            "domaine" => "required",
        ]);

        if ($validator->passes()) {
            $program = Programs::find($id);
            $program->date_id = $request->date_id;
            $program->domaine = $request->domaine;
            $program->save();

            Session::flash('success', 'The program was successfully updated.');
            return response()->json([
                'status' => true,
                'message' => 'Program updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete ($id) {
        $program = Programs::find($id);
        $program->delete();

        Session::flash('success', 'The project was successfully deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Project deleted successfully',
        ]);
    }
}
