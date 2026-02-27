<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberSubscription extends Model
{
    use HasFactory;

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
