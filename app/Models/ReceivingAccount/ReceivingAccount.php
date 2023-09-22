<?php

namespace App\Models\ReceivingAccount;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivingAccount extends Model
{
    use HasFactory;
    protected $guarded = array();
    protected $table = 'receiving_accounts';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
