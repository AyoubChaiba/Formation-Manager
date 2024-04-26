<?php

namespace App\Http\Controllers;

use App\Models\Contact_beneficiaries;
use App\Models\Wishes;
use Illuminate\Http\Request;

class ContactBeneficiariesController extends Controller
{
    public function show($id)
    {
        $contacts = Contact_beneficiaries::with('GetBeneficiarie')
        ->where('contact_id', $id)
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
        return view('admin.pages.contact.show', compact('contacts'));

    }
    public function msg(Request $request)
    {
        $contacts = Wishes::with('getCourse')->where("beneficiarie_id" , $request->id)->paginate(10);
        return view('admin.pages.contact.msg', compact('contacts'));
    }
}
