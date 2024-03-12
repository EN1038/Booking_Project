<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_room',
        // ระบุฟิลด์อื่นๆ ที่ต้องการให้สามารถ mass assignment ได้ตามต้องการ
    ];
    public function typeRoom()
    {
        
        return $this->belongsTo(TypeRoom::class, 'id_type_room', 'id');
    }
}
