<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use App\Models\Responsibles;
use App\Models\Target_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TargetGroupsController extends Controller
{

    public function index() {
        $targetGroups = Target_groups::with('Programs')->with('Responsibles')->with('GetCourses')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.targetGroups.list', compact('targetGroups'));
    }
    public function create() {
        $responsibles = Responsibles::orderBy('created_at','DESC')->where('status', 1)->get();
        $programs = Programs::orderBy('created_at','DESC')->get();
        return view('admin.pages.targetGroups.create', compact('programs','responsibles'));
    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "responsible_id" => "required",
            "program_id" => "required",
        ]);

        if ($validator->passes()) {
            $targetGroup = new Target_groups();
            $targetGroup->responsible_id = $request->responsible_id;
            $targetGroup->program_id = $request->program_id;
            $targetGroup->name = $request->name;
            $targetGroup->save();

            Session::flash('success', 'The target group was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Target group added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id) {
        $targetGroup = Target_groups::find($id);
        $responsibles = Responsibles::orderBy('created_at','DESC')->where('status', 1)->get();
        $programs = Programs::orderBy('created_at','DESC')->get();
        return view('admin.pages.targetGroups.edit', compact('targetGroup','programs','responsibles'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:target_groups,name," . $request->id,
            "responsible_id" => "required",
            "program_id" => "required",
        ]);

        if ($validator->passes()) {
            $targetGroup = Target_groups::find($id);
            $targetGroup->responsible_id = $request->responsible_id;
            $targetGroup->program_id = $request->program_id;
            $targetGroup->name = $request->name;
            $targetGroup->save();

            Session::flash('success', 'The target group was successfully updated.');
            return response()->json([
                'status' => true,
                'message' => 'Target group updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete ($id) {
        $targetGroup = Target_groups::find($id);
        $targetGroup->delete();

        Session::flash('success', 'The target group was successfully deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Target group deleted successfully',
        ]);
    }
}
