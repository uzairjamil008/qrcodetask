<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Locations\Cities;
use App\Models\Locations\Countries;
use App\Models\Product\Product;
use App\Models\Reservations\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use QrCode;

class BookingController extends Controller
{
    public function businesses($columnval, $column)
    {
        if ($columnval == 'Luxury Cars' || $columnval == 'Race Tracks' || $columnval == 'ATVS' || $columnval == 'Jet Skis' || $columnval == 'Boat and Yatch') {
            $columnval = 'Vehicles-ATV-Bikes-Boats-JetSkis';
        }

        $data['results'] = User::where($column, $columnval)->where('hide_listing', '!=', 1)->get();

        foreach ($data['results'] as $key => $value) {
            $value->country = isset($value->countries->location_country_name) ? $value->countries->location_country_name : '';
            $value->city = isset($value->cities->location_city_name) ? $value->cities->location_city_name : '';
        }
        $response = array('businesses' => $data['results']);
        return json_encode($response);
    }
    public function business_details($id)
    {
        $data['details'] = User::where('id', $id)->first()->toArray();
        $data['products'] = Product::where('business_id', $id)->get()->toArray();
        // dd($data['products']);
        $response = array('status' => 1, 'details' => $data['details'], 'products' => $data['products']);
        return json_encode($response);
    }
    public function products($id)
    {
        $data['products'] = Product::where('business_id', $id)->get()->toArray();
        $response = array('products' => $data['products']);
        return json_encode($response);
    }
    public function productdetail($id)
    {
        $data['product'] = Product::where('id', $id)->get()->toArray();
        $response = array('product' => $data['product']);
        return json_encode($response);
    }
    public function singleproduct($id)
    {

        $product = Product::with('businesses')->where('id', $id)->first();
        if ($product) {
            $product->feature = isset($product->businesses->feature) ? $product->businesses->feature : '';
            // unset($product->businesses);
            unset($product->businesses->map);

            unset($product->description);
            $product->price = str_replace('$', '', $product->price);
            $product->fee = str_replace('$', '', $product->fee);
        }
        $response = array('product' => $product);
        return json_encode($response);
    }

    public function reservations($id, $type, $type2)
    {
        $data['business_type'] = $type2;
        $data['type'] = $type;
        $data['id'] = $id;
        $data['reservation'] = Product::where('id', $id)->first();
        $response = array('status' => 1, 'reservation' => $data['reservation']);
        return json_encode($response);
    }
    public function make_payment2($request)
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
        } catch (\Exception $e) {
            return array('success' => false, 'message' => 'Error from stripe');
        }

    }

    public function make_payment($request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $user = Auth::user();

        // $stripe_customer_id = $user->stripe_customer_id;
        try {
            $expiry = explode('/', $request->expiry);
            $month = $expiry[0];
            $year = '20' . $expiry[1];

            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
                'description' => "customer info for Themaxhyped",
                "source" => $request->stripe_token,
            ]);
            $stripe_customer_id = $customer->id;

            $cardParams = [
                'number' => $request->card_number,
                'exp_month' => $month,
                'exp_year' => $year,
                'cvc' => $request->cvc,
            ];

            $paymentMethod = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => $cardParams,
            ]);

            $stripe->paymentMethods->attach(
                $paymentMethod->id,
                ['customer' => $stripe_customer_id]
            );

            $intent = $stripe->paymentIntents->create([
                'amount' => $request->net_amount * 100,
                'currency' => 'usd',
                'confirm' => true,
                // 'capture_method' => 'manual',
                'customer' => $stripe_customer_id,
                'payment_method' => $paymentMethod->id,
                'statement_descriptor' => 'Themaxhyped',
                'description' => $request->title . ' Purchase',
            ]);

            return array('success' => true, 'message' => 'Payment done', 'intent' => $intent);

        } catch (\Stripe\Exception\CardException $e) {
            return array('success' => false, 'message' => $e->getError()->message);
        } catch (\Exception $e) {
            return array('success' => false, 'message' => 'Error from stripe');
        }

    }

    public function save_reservation(Request $request)
    {
        $date = date('Y-m-d h:i');
        $time = date('h:i');
        $stripe_intent_id = null;
        if ($request->type == 'Purchase') {
            // $response = $this->make_payment($request);
            // if (!$response['success']) {
            //     return json_encode($response);
            // }
            // $stripe_intent_id = $response['intent']->id;
        } else {
            if ($request->date) {
                $date = date("Y-m-d h:i", strtotime($request->date));
                $time = date("h:i", strtotime($request->date));
            }
        }

        $random = hexdec(uniqid());
        $data['order_number'] = substr($random, 0, 8);
        $data = array(
            'date' => $date,
            'time' => $time,
            'order_number' => substr($random, 0, 8),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'remarks' => $request->remarks,
            'people' => $request->type == 'Reservation' ? $request->people : '',
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'business_id' => $request->business_id,
            'type' => $request->type,
            'price' => $request->type == 'Purchase' ? $request->price : '',
            'fee' => $request->type == 'Purchase' ? $request->fee : '',
            'discount_code' => $request->type == 'Purchase' ? $request->discount_code : '',
            'discount_amount' => $request->type == 'Purchase' ? $request->discount_amount : '',
            'discount_percentage' => $request->type == 'Purchase' ? $request->discount_percentage : '',
            'net_amount' => $request->type == 'Purchase' ? $request->net_amount : '',
            'total_tickets' => $request->type == 'Purchase' ? $request->people : '',
            'stripe_intent_id' => $request->stripe_intent_id ?? null,
        );

        if (!empty($request->check_out_date)) {
            $check_out_date = date("Y-m-d h:i", strtotime($request->check_out_date));
            $data['check_out_date'] = $check_out_date;
        }
        if (!empty($request->return_date_time)) {
            $return_date_time = date("Y-m-d h:i", strtotime($request->return_date_time));
            $data['return_date_time'] = $return_date_time;
        }
        $data['qr_code'] = QrCode::size(100)->generate(json_encode($data));
        $affected_rows = Reservation::create($data);

        $data['business'] = User::where('id', $request->business_id)->first();
        $data['cities'] = Cities::where('id', $data['business']->city)->first();
        $data['country'] = Countries::where('id', $data['business']->country)->first();

        $business_email = $data['business']->email;
        if (!empty($data['business']->affiliate_id)) {
            $data['affiliate'] = User::where('id', $data['business']->affiliate_id)->first();
            $affiliate_email = $data['affiliate']->email;
            if (!empty($affiliate_email)) {
                $ccemail = [$business_email, $affiliate_email, env('ADMIN_EMAIL')];
            }
        } else {
            $ccemail = [$business_email, env('ADMIN_EMAIL')];
        }
        $data['customer'] = User::where('id', $request->customer_id)->first();
        $to_email = $data['customer']->email;

        $template = view('frontend.emails.booking_email_mobile', compact('data'))->render();
        $this->send_email($to_email, $ccemail, 'Welcome to Maxhype', 'frontend.emails.booking_email_mobile', $data);
        $response = array('success' => true, 'message' => $request->type . ' made successfully');
        return json_encode($response);
    }
    public function send_email($to_email, $ccemail, $subject, $template, $data)
    {

        Mail::send($template, ['data' => $data], function ($message) use ($subject, $to_email, $ccemail) {

            $message->to($to_email, $subject)->subject($subject)
                ->bcc($ccemail, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);

        });

    }

    public function discount(Request $request)
    {
        $amount = $request->input('amount');
        $discountExist = User::where('id', $request->business_id)->where('discount_code', $request->discount_code)->first();
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

    public function search(Request $request)
    {
        $search = $request->input('search');
        $data['business'] = User::where('role_id', 3)->where('hide_listing', '!=', 1)->where('first_name', 'LIKE', '%' . $search . '%')->get();
        $data['location'] = Countries::where('location_country_name', 'LIKE', '%' . $search . '%')->get();
        $data['cities'] = Cities::where('location_city_name', 'LIKE', '%' . $search . '%')->get();
        $data['tickets'] = Reservation::where('order_number', 'LIKE', '%' . $search . '%')->get();
        return response()->json($data);
    }

    public function payment_intent(Request $request)
    {
        try {
            $business = User::where('id', $request->business_id)->first();
            $user = User::where('id', $request->user_id)->first();

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $amount = $request->net_amount;
            $intent = $stripe->paymentIntents->create([
                "amount" => $amount * 100,
                "currency" => "USD",
                'payment_method_types' => ['card'],
                'metadata' => [
                    'customer' => $user->first_name . ' ' . $user->last_name,
                    'customer ID' => $user->id,
                    'customer email' => $user->email,
                    'business email' => $business->email,
                ],
            ]);
            $response = array('success' => true, 'client_secret' => $intent->client_secret);
        } catch (\Exception $e) {
            $response = array('success' => false, 'message' => $e->getMessage());
        }
        return json_encode($response);
    }
}
