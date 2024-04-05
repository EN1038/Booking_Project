<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeRoom extends Model
{
    use HasFactory;
    protected $fillable = ['name_type', 'time_duration', 'number_user','time_cancel' ,'id_type_room'];
    
    
    public function listRooms()
    {
        return $this->hasMany(ListRoom::class, 'id_type_room', 'id');
    }
}
