<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAccount\CustomerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAccountController extends Controller
{
    public function cutomerPayments(Request $request)
    {
        $user = Auth::user();
        $inserted_data = CustomerAccount::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'card_number' => $request->card_number,
                'expiry' => $request->expiry,
                'cvc' => $request->cvc,
            ]
        );
        $response = array('message' => 'Card Saved Successfully');
        return $response;
    }
}
