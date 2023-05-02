<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id','answer'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
