<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    public function subject_info() {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function institute_info() {
        return $this->belongsTo(Universities::class, 'institute_id');
    }

    public function added_by_info() {
        return $this->belongsTo(User::class, 'added_by');
    }


}
