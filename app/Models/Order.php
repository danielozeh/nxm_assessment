<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function count_referrals() {
        return $this->hasMany(User::class, 'id', 'purchaser_id')->where('users.referred_by', $this->id);
    }
}
