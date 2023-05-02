<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerEducation extends Model
{
    protected $fillable = [
        'institute_name','gpa','education_level','passing_year','location','career_id'
    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
