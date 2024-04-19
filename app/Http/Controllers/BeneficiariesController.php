<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaries;
use App\Models\Programs;
use App\Models\Target_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BeneficiariesController extends Controller
{
    public function index() {
        $beneficiarie = Beneficiaries::with('TargetGroups')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.pages.beneficiaries.list', compact('beneficiarie'));
    }
    public function create() {
        $programs = Programs::orderBy('created_at','DESC')->get();
        return view('admin.pages.beneficiaries.create', compact('programs'));
    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            "program_id" => "required",
            "target_group_id" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "ppr" => "required|unique:beneficiaries,PPR",
            "workplace" => "required",
            "gender" => "required",
            "phone_number" => "required|unique:beneficiaries,phone_number",
            "email" => "required|unique:beneficiaries,email",
        ]);

        if ($validator->passes()) {
            $beneficiarie = new Beneficiaries();
            $beneficiarie->program_id = $request->program_id;
            $beneficiarie->target_group_id = $request->target_group_id;
            $beneficiarie->first_name = $request->first_name;
            $beneficiarie->last_name = $request->last_name;
            $beneficiarie->ppr = $request->ppr;
            $beneficiarie->workplace = $request->workplace;
            $beneficiarie->gender = $request->gender;
            $beneficiarie->phone_number = $request->phone_number;
            $beneficiarie->email = $request->email;
            $beneficiarie->save();

            Session::flash('success', 'The beneficiarie was successfully added.');
            return response()->json([
                'status' => true,
                'message' => 'Beneficiarie added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id) {
        $beneficiarie = Beneficiaries::find($id);
        $programs = Programs::orderBy('created_at','DESC')->get();
        $target_groups = Target_groups::orderBy('created_at','DESC')->get();
        return view('admin.pages.beneficiaries.edit', compact('beneficiarie','programs','target_groups'));
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "program_id" => "required",
            "target_group_id" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "ppr" => "required|unique:beneficiaries,PPR," . $request->id,
            "workplace" => "required",
            "gender" => "required",
            "phone_number" => "required|unique:beneficiaries,phone_number," . $request->id,
            "email" => "required|unique:beneficiaries,email," . $request->id,
        ]);

        if ($validator->passes()) {
            $beneficiarie = Beneficiaries::find($request->id);
            $beneficiarie->program_id = $request->program_id;
            $beneficiarie->target_group_id = $request->target_group_id;
            $beneficiarie->first_name = $request->first_name;
            $beneficiarie->last_name = $request->last_name;
            $beneficiarie->ppr = $request->ppr;
            $beneficiarie->workplace = $request->workplace;
            $beneficiarie->gender = $request->gender;
            $beneficiarie->phone_number = $request->phone_number;
            $beneficiarie->email = $request->email;
            $beneficiarie->save();

            Session::flash('success', 'The beneficiarie was successfully updated.');
            return response()->json([
                'status' => true,
                'message' => 'Beneficiarie updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function delete ($id) {
        $beneficiarie = Beneficiaries::find($id);
        $beneficiarie->delete();

        Session::flash('success', 'The beneficiarie was successfully deleted.');
        return response()->json([
            'status' => true,
            'message' => 'Beneficiarie deleted successfully',
        ]);
    }
}
