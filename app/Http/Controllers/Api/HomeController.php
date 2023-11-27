<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Models\Locations\Cities;
use App\Models\Product\Product;
use App\Models\SiteContent\SiteContent;
use App\Models\Slider\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function mainslider()
    {
        $data['slider'] = Slider::get()->take(8);
        $response = array('status' => 1, 'slider' => $data['slider']);
        return json_encode($response);
    }
    public function topproducts()
    {
        $data['product'] = Product::select('products.id', 'price', 'fee', 'total_tickets', 'title', 'tickets_available', 'feature')
            ->join('users', 'users.id', '=', 'products.business_id')
            ->whereDate('expiry_date', '>', Carbon::now())->orWhereNull('expiry_date')
            ->take(5)->get();
        $response = array('status' => 1, 'product' => $data['product']);
        return json_encode($response);
    }

    public function topcountries()
    {
        $countries = DB::table('users')->join('location_countries', 'users.country', '=', 'location_countries.id')
            ->select('location_countries.location_country_name', 'location_countries.id as country_id')->groupBy('location_countries.id')->get();
        foreach ($countries as $key => $value) {
            $value->cities = Cities::where('location_country_id', $value->country_id)->select('location_city_name', 'id')->get();
        }
        $response = array('status' => 1, 'countries' => $countries);
        return json_encode($response);
    }
    public function topbusiness()
    {
        $data['business'] = User::where('role_id', 3)->where('hide_listing', '!=', 1)
        // ->where('top_business', '=', 1)
        ->take(6)->get();
        $response = array('status' => 1, 'businesses' => $data['business']);
        return json_encode($response);
    }

    public function types()
    {
        // $data['businesstypes'] = ['Bar & Stores', 'Restaurants', 'Vehicles-ATV-Bikes-Boats-JetSkis', 'Adult Entertainment', 'Adventures', 'Afrobeats', 'Sky Diving', 'Movie Theaters & Hotels', 'Clubs'];
        // $data['businesstypes'] = ['Bar & Stores', 'Restaurants', 'Vehicles-ATV-Bikes-Boats-JetSkis', 'Adult Entertainment', 'Medical Marijuana & CBD', 'Adventures', 'Afrobeats', 'Sky Diving', 'Movie Theaters & Hotels', 'Clubs'];
        $data['businesstypes'] = mobile_categories();
        $response = array('status' => 1, 'types' => $data['businesstypes']);
        return json_encode($response);
    }

    public function site_content()
    {
        $data = SiteContent::first();
        $response = array('status' => 1, 'data' => $data);
        return json_encode($response);
    }
}
