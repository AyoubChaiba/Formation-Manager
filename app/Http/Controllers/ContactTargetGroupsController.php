<?php

namespace App\Http\Controllers;

use App\Mail\emailMailable;
use App\Models\Contact_beneficiaries;
use App\Models\Contact_target_groups;
use App\Models\Programs;
use App\Models\Target_groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Illuminate\Support\Facades\Http;

class ContactTargetGroupsController extends Controller
{
    private $vonageApiKey;
    private $vonageApiSecret;

    public function __construct()
    {
        $this->vonageApiKey = "702cf6dc";
        $this->vonageApiSecret = "9h7hoW3fVQQIwtJV";
    }

    public function index()
    {
        $contacts = Contact_target_groups::with('Programs')
            ->with('TargetGroups')
            ->with("GetBeneficiaries")
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return view('admin.pages.contact.list', compact('contacts'));
    }

    public function create()
    {
        $programs = Programs::orderBy('created_at', 'DESC')->get();
        return view('admin.pages.contact.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "program_id" => "required",
            "target_group_id" => "required",
            "message" => "required",
            "provider" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $contact = new Contact_target_groups();
        $contact->program_id = $request->program_id;
        $contact->target_group_id = $request->target_group_id;
        $contact->message = $request->message;
        $contact->provider = implode(",", $request->provider);
        $targetGroups = Target_groups::with('GetBeneficiaries')->find($request->target_group_id);

        if (!$targetGroups || $targetGroups->GetBeneficiaries->isEmpty()) {
            return response()->json([
                'error' => false,
                'error_message' => 'Target group not found or has no beneficiaries'
            ]);
        }

        $contact->save();

        foreach ($targetGroups->GetBeneficiaries as $beneficiary) {
            $this->sendMessages($request->provider, $beneficiary, $request->target_group_id, $contact);
        }

        Session::flash('success', 'The message was sent successfully');

        return response()->json([
            'status' => true,
            'message' => 'Contact added successfully'
        ]);
    }

    public function delete($id) {
        $contact = Contact_target_groups::find($id);
        $contact->delete();
        return response()->json([
            'status' => true,
            'message' => 'The contact was successfully deleted.',
        ]);
    }

    private function sendMessages($providers, $beneficiary, $targetGroupId,$contact)
    {
        $url = url("/wish/$targetGroupId/{$beneficiary->ppr}");
        $beneficiaryContact = new Contact_beneficiaries ;
        $beneficiaryContact->contact_id = $contact->id;
        $beneficiaryContact->beneficiarie_id = $beneficiary->id;
        $beneficiaryContact->url = $url;
        foreach ($providers as $provider) {
            switch ($provider) {
                case "sms":
                    $this->sendSms($beneficiary->phone_number, $url);
                    break;
                case "whatsapp":
                    $this->sendWhatsapp($beneficiary->phone_number, $url);
                    break;
                case "email":
                    $this->sendEmail($beneficiary->email, $url);
                    break;
            }
        }
        $beneficiaryContact->save();
    }

    private function sendWhatsapp($number, $url)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
        ->withBasicAuth('702cf6dc', '9h7hoW3fVQQIwtJV')
        ->post('https://messages-sandbox.nexmo.com/v1/messages', [
            'from' => '14157386102',
            'to' => "212678256788",
            'message_type' => 'text',
            'text' => "رابط لإبدائ رغبة لي إجتياز تكوين $url",
            'channel' => 'whatsapp',
        ]);
        if ($response->successful()) {
            $response->status();
        } else {
            $response->status();
        }
    }

    private function sendSms($number, $url)
    {
        $client = new Client(new \Vonage\Client\Credentials\Basic($this->vonageApiKey, $this->vonageApiSecret));
        $response = $client->sms()->send(
            new SMS("212678256788", "BRAND SMS AYO", "رابط لإبدائ رغبة لي إجتياز تكوين $url")
        );
        $message = $response->current();
    }

    private function sendEmail($email, $url)
    {
        $toEmail = $email;
        $subject = "Your Subject Here";
        $message = "رابط لإبدائ رغبة لي إجتياز تكوين $url";
        $emailMailable = new emailMailable($message, $subject);
        Mail::to($toEmail)->send($emailMailable);
    }
}
