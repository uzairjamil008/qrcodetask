<?php

namespace App\Models\Reservations;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = array();
    protected $table = 'business_reservation';
    public function business_name()
    {
        return $this->belongsTo('App\Models\User', 'business_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
