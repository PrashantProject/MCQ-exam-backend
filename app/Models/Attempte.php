<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempte extends Model
{
    use HasFactory;
    protected $table="attemptes";
    protected $fillable = [
       'user_id', 'question_id', 'option_id',
    ];
}
