<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Leveluser extends Authenticatable
{
    use HasFactory;

public function book_detail()
{
    return $this->belongsTo(book_details::class, 'user_id');
}
    
}
