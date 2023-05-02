<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'name','email','phone','image','resume','address','cover_letter','a_o_i','perferred_location','job_id'
    ];

    public function educations()
    {
        $this->hasMany(CareerEducation::class);
    }
}
