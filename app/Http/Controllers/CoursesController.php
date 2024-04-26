<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\CoursesTarget_group;
use App\Models\Programs;
use App\Models\R_CoursesTarget;
use App\Models\Target_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    public function index() {
        $courses = Courses::with('Programs')->with('TargetGroups')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.courses.list', compact('courses'));
    }
    public function create() {
        $programs = Programs::withCount('GetTargetgroups')->orderBy('created_at', 'DESC')->get();
        return view('admin.pages.courses.create', compact('programs'));
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "target_group_id" => "required",
            "program_id" => "required",
            "name" => "required",
            "course_type" => "required",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        if ($validator->passes()) {
            $course = new Courses();
            $course->program_id = $request->program_id;
            $course->name = $request->name;
            $course->course_type = $request->course_type;
            $course->start_date = $request->start_date;
            $course->end_date = $request->end_date;
            $course->status = $request->status;
            $course->save();


            foreach ($request->target_group_id as $group_id) {
                $targetGroup = new R_CoursesTarget();
                $targetGroup->target_group_id = $group_id;
                $targetGroup->course_id = $course->id;
                $targetGroup->save();
            }

            Session::flash('success', 'The course was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Course added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id) {
        $course = Courses::orderBy('created_at','DESC')->with('TargetGroups')->find($id);
        $programs = Programs::orderBy('created_at','DESC')->get();
        $targetGroups = Target_groups::orderBy('created_at','DESC')->where('program_id', $course->program_id)->get();
        return view('admin.pages.courses.edit', compact('course','programs','targetGroups'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "target_group_id" => "required",
            "program_id" => "required",
            "name" => "required",
            "course_type" => "required",
            "start_date" => "required",
            "end_date" => "required",
        ]);

        if ($validator->passes()) {
            $course = Courses::find($id);
            $course->program_id = $request->program_id;
            $course->name = $request->name;
            $course->course_type = $request->course_type;
            $course->start_date = $request->start_date;
            $course->end_date = $request->end_date;
            $course->status = $request->status;
            $course->save();

            Session::flash('success', 'The course was successfully updated.');
            return response()->json([
                'status' => true,
                'message' => 'Course updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete ($id) {
        $course = Courses::find($id);
        $course->delete();

        Session::flash('success', 'The course was successfully deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Course deleted successfully',
        ]);
    }

    public function programTarget(Request $request) {
        $target_groups = Target_groups::withCount("GetCourses")->where('program_id',$request->id)
            ->orderBy('name','ASC')
            ->get(['name','id']);
        return response()->json($target_groups);
    }
}
