<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    public function driver()
    {
        return $this->hasOne(Driver::class,'id_device');
    }

    
}
