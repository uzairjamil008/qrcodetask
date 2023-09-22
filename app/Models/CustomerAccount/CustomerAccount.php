<?php

namespace App\Models\CustomerAccount;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    use HasFactory;
    protected $guarded = array();
    protected $table = 'customer_accounts';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
