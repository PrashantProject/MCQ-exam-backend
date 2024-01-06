<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{
    use HasFactory;
    protected $table="question_sets";
    protected $fillable = [
         'set_name','title','instruction'
    ];


    public function questions()
    {
        return $this->hasMany(Question::class,'set_id');
    }
}
