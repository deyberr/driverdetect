<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    public function user()
    {
        return  $this->belongsTo(User::class,'id_user');
    }
    public function device()
    {
        return  $this->belongsTo(Device::class,'id_device');
    }
}
