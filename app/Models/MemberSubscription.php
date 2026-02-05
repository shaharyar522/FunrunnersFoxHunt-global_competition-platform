<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSubscription extends Model
{
    protected $fillable = [
        'member_id',
        'status',
        'payments',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
