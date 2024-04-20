<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class typeRoom extends Model
{
    use HasFactory;
    protected $fillable = ['name_type', 'time_duration', 'number_user','time_cancel' ,'id_type_room','time_late'];
    
    
    public function listRooms()
    {
        return $this->hasMany(ListRoom::class, 'id_type_room', 'id');
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
