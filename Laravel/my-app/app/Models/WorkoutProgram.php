<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutProgram extends Model
{
    protected $fillable = ["trainer_id","name", "description", "duration"];
    
}
