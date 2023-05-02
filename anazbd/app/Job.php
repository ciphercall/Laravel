<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Career;

class Job extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'job_type',
        'description',
        'salary',
        'experience',
        'min_qualification',
        'department',
        'gender',
        'location',
        'contact_email',
        'contact_mobile',
        'note',
        'deadline'
    ];

    protected $dates = ['deadline'];

    public function applications()
    {
        return $this->hasMany(Career::class);
    }
}
