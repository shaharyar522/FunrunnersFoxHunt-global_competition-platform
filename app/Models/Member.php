<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'payment_status',
        'subscription_ends_at',
        'status',
    ];


    protected $casts = [
        'subscription_ends_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function subscriptions()
    {
        return $this->hasMany(MemberSubscription::class, 'member_id');
    }

    
    public function activeSubscription()
    {
        return $this->hasOne(MemberSubscription::class, 'member_id')
            ->where('status', 1)
            ->latest();
    }
}
