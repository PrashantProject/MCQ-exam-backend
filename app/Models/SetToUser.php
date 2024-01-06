<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetToUser extends Model
{
    use HasFactory;
    protected $table="set_to_users";
    protected $fillable = [
         'user_id','set_id'
    ];
    public $timestamps = false;
}
