<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class book_details extends Model
{
    use HasFactory;
    public function booking()
{
    return $this->belongsTo(booking::class, 'booking_id');
}

public function Leveluser()
{
    return $this->belongsTo(Leveluser::class, 'user_id');
}

public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->setTimezone('Asia/Bangkok');
    }

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = Carbon::parse($value)->setTimezone('Asia/Bangkok');
    }
}
