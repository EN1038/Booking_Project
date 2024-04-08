<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class listRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_room',
        // ระบุฟิลด์อื่นๆ ที่ต้องการให้สามารถ mass assignment ได้ตามต้องการ
    ];
    public function typeRoom()
{
    return $this->belongsTo(TypeRoom::class, 'id_type_room');
}

public function workTimes()
{
    return $this->hasMany(Work_Time::class, 'id_room');
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
