<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class work_time extends Model
{
    use HasFactory;
    public function listRoom()
{
    return $this->belongsTo(ListRoom::class, 'id_room');
}

}
