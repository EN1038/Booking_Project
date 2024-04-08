<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class work_time extends Model
{
    use HasFactory;
    public function listRoom()
{
    return $this->belongsTo(ListRoom::class, 'id_room');
}
public function booking()
{
    return $this->hasMany(Booking::class, 'workTime_id');
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
