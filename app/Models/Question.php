<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table="questions";
    protected $fillable = [
         'set_id','question'
    ];

    public function option()
    {
        return $this->hasMany(Option::class,'question_id');
    }
}
