<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ReceivingAccount\ReceivingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceivingAccountController extends Controller
{
    public function receivingAccounts(Request $request)
    {
        $user = Auth::user();
        $inserted_data = ReceivingAccount::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'account_no' => $request->account_no,
                'routing_no' => $request->routing_no,
                'bank' => $request->bank,
                'account_title' => $request->account_title,
                'iban' => $request->iban,
            ]
        );
        $response = array('message' => 'Account Details Saved Successfully');
        return $response;
    }
}
