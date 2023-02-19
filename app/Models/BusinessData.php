<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessData extends Model
{
    use HasFactory;

    public function added_by_info() {
        return $this->belongsTo(User::class, 'added_by');
    }
    
}
