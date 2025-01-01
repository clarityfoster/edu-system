<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;
    public function user() {
        return $this->hasMany(User::class);
    }
    public function course() {
        return $this->hasMany(Course::class);
    }
}
