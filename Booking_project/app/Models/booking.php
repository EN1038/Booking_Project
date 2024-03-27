<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    use HasFactory;
    public function work_time()
{
    return $this->belongsTo(work_time::class, 'workTime_id');
}

public function book_detail()
{
    return $this->hasMany(book_details::class, 'booking_id');
}
}
