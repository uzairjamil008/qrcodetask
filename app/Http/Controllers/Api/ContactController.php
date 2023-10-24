<?php
namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Models\Contacts\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Support\Facades\Auth;
class ContactController extends Controller
{
    public function savecontact(Request $request)
    {
        $data = $request->all();
        $action = "Added";
        $affected_rows = Contact::create($data);
        $this->send_email($request->email, 'Welcome to Maxhype', 'frontend.emails.contacts_email', $data);
        $response = array('status' => 1, 'response' => json_encode($affected_rows));
        return $response;
    }

    public function send_email($email, $subject, $template, $data)
    {
        Mail::send($template, ['data' => $data], function ($message) use ($subject, $email) {
            $message->to($email, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);
        });
    }
}
