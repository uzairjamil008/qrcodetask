<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = array();
    protected $table = 'products';
    protected $appends = ['item_label', 'is_checkout'];



    public function businesses()
    {
        return $this->belongsTo('App\Models\User', 'business_id', 'id');
    }

    public function getItemLabelAttribute()
    {
        return "How many tables, tickets,products or services do you want";
    }
    public function getIsCheckoutAttribute()
    {
        if (in_array($this->businesses->type, checkout_categories())) {
            return true;
        }
        return false;
    }
}
