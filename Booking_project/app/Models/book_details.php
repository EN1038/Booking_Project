<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
