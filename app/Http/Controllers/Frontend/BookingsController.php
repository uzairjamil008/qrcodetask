<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAccount\CustomerAccount;
use App\Models\Locations\Cities;
use App\Models\Locations\Countries;
use App\Models\Product\Product;
use App\Models\Reservations\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QrCode;

class BookingsController extends Controller
{
    public function businesses($type)
    {
        $data['type'] = $type;
        $data['results'] = User::where('type', $type)->where('hide_listing', '!=', 1)->paginate(6);
        return view('frontend.businesses.index', compact('data'));
    }
    public function business_details($id)
    {
        $data['businesses'] = User::where('role_id', 3)->get();
        $data['details'] = User::where('id', $id)->first();
        $data['type'] = $data['details']['feature'];
        $data['products'] = Product::whereDate('expiry_date', '>', Carbon::now())->orWhereNull('expiry_date')->where('business_id', $id)->get();
        return view('frontend.businesses.details', compact('data'));
    }
    public function reservation($id, $type, $type2)
    {
        $user = Auth::user();
        $data['business_type'] = $type2;
        $data['type'] = $type;
        $data['id'] = $id;
        $data['details'] = Product::where('id', $id)->first();
        $data['price'] = $data['details']['price'];
        $data['price'] = str_replace("$", "", $data['price']);
        $data['fee'] = $data['details']['fee'];
        $data['fee'] = str_replace("$", "", $data['fee']);
        $data['total_tickets'] = $data['details']->total_tickets;
        $data['card_data'] = CustomerAccount::where('user_id', $user->id)->select('card_number', 'expiry', 'cvc')->first();
        // Fetch the is_return value from the product
        $is_return = $data['details']->is_return;
        // Add the is_return value to the $data array
        $data['is_return'] = $is_return;
        return view('frontend.businesses.reservation', compact('data'));
    }

    public function save_reservation(Request $request)
    {
        $data = $request->all();
        $random = hexdec(uniqid());
        $data['order_number'] = substr($random, 0, 8);
        // $data['date'] = db_format_date_slash($request->date);
        if (!empty($request->date)) {
            $data['date'] = date('Y-m-d H:i:s', strtotime($request->date));
        }
        if (!empty($request->check_out_date)) {
            $data['check_out_date'] = date('Y-m-d H:i:s', strtotime($request->check_out_date));
        }
        if (!empty($request->return_date_time)) {
            $data['return_date_time'] = date('Y-m-d H:i:s', strtotime($request->return_date_time));
        }
        $data['qr_code'] = QrCode::size(100)->generate(json_encode($data));
        if ($request->type == 'Purchase') {
            $response = $this->make_payment($request);
            if (!$response['success']) {
                return json_encode($response);
            }
        }
        if (isset($data['card_number'])) {
            unset($data['card_number']);
            unset($data['expiry']);
            unset($data['cvc']);
        }
        $affected_rows = Reservation::create($data);
        $data['business'] = User::where('id', $request->business_id)->first();
        $data['business_address'] = $data['business']->address;
        $data['cities'] = Cities::where('id', $data['business']['city'])->first();
        $data['country'] = Countries::where('id', $data['business']['country'])->first();
        $business_email = $data['business']['email'];
        if (!empty($data['business']->affiliate_id)) {
            $data['affiliate'] = User::where('id', $data['business']->affiliate_id)->first();
            $affiliate_email = $data['affiliate']['email'];
            if (!empty($affiliate_email)) {
                $ccemail = [$business_email, $affiliate_email, env('ADMIN_EMAIL')];
            }
        } else {
            $ccemail = [$business_email, env('ADMIN_EMAIL')];
        }
        $to_email = Auth::user()->email;
        sendEmail($to_email, $ccemail, 'Welcome to Maxhype', 'frontend.emails.mail', $data);
        $response = array('response' => $affected_rows);
        return json_encode($response);
    }

    public function make_payment($request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        try {
            $expiry = explode('/', $request->expiry);
            $month = $expiry[0];
            $year = '20' . $expiry[1];
            $token_obj = $stripe->tokens->create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $request->cvc,
                ],
            ]);

            $stripe->charges->create([
                'amount' => $request->net_amount * 100,
                'currency' => 'usd',
                'source' => $token_obj->id,
                'description' => $request->title . ' Purchase',
            ]);
            return array('success' => true, 'message' => 'Payment done');

        } catch (\Stripe\Exception\CardException $e) {
            return array('success' => false, 'message' => $e->getError()->message);
        } catch (Exception $e) {
            return array('success' => false, 'message' => 'Error from stripe');
        }

    }
    public function paymentintent(Request $request)
    {
        $business = User::where('id', $request->business_id)->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $amount = $request->net_amount;
        $intent = $stripe->paymentIntents->create([
            "amount" => $amount * 100,
            "currency" => "USD",
            'metadata' => [
                'customer' => $request->first_name . ' ' . $request->last_name,
                'customer ID' => $request->customer_id,
                'customer email' => Auth::user()->email,
                'business email' => $business->email,
            ],
        ]);

        // Session::flash('success', 'Payment successful!');
        return $intent->client_secret;
    }
    public function search()
    {
        $search = $_GET['search'];
        $data['business'] = User::where('role_id', 3)->where('first_name', 'LIKE', '%' . $search . '%')->get();
        $data['location'] = Countries::where('location_country_name', 'LIKE', '%' . $search . '%')->get();
        $data['cities'] = Cities::where('location_city_name', 'LIKE', '%' . $search . '%')->get();
        $data['tickets'] = Reservation::where('order_number', 'LIKE', '%' . $search . '%')->get();
        $response = view('frontend.dashboard.search', compact('data'))->render();
        $response = array('response' => $response);
        return json_encode($response);
    }
    public function products_details($id)
    {
        $data['products'] = Product::where('id', $id)->first();
        $details = $data['products']['description'];
        $response = array('response' => $details);
        return json_encode($response);
    }

    public function checkDiscount(Request $request)
    {
        $amount = $request->input('amount');
        $discountExist = User::where('discount_code', $request->discount_code)->first();
        $valid = false;
        $response = [
            'valid' => $valid,
        ];
        if ($discountExist) {
            $valid = true;
            $discount = $discountExist->discount;
            if (strpos($discount, '%') !== false) {
                $discount = str_replace('%', '', $discount);
            }

            $discount = floatval($discount);

            $discount_amount = ($amount * $discount) / 100;
            $net_amount = $amount - $discount_amount;

            $response = [
                'valid' => $valid,
                'discount_code' => $request->discount_code,
                'discount_amount' => $discount_amount,
                'discount_percentage' => $discount,
                'amount' => $amount,
                'net_amount' => $net_amount,
            ];
        }

        return $response;
    }

    public function saveData(Request $request)
    {
        $data = [
            'status' => $request->status,
            'business_remarks' => $request->business_remarks,
            'customer_spent' => $request->customer_spent,
            'admin_notes' => $request->admin_notes,
        ];
        Reservation::where('id', $request->business_reservation_id)->update($data);
        return redirect()->back();

    }
}
