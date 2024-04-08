<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class booking extends Model
{
    use HasFactory;
    protected $fillable = [
        // เพิ่ม 'status_book' เข้าไปใน array นี้
        'status_book',
        // ค่าอื่นๆ ที่คุณต้องการให้สามารถ mass assignment ได้
    ];
    public function work_time()
    {
        return $this->belongsTo(work_time::class, 'workTime_id');
    }

    public function book_detail()
    {
        return $this->hasMany(book_details::class, 'booking_id');
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
