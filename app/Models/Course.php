<?php

namespace App\Models;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    public function semester()
    {
        return $this->belongsToMany(Semester::class, 'semester_courses', 'course_id', 'semester_id');
    }
    public function user() {
        return $this->hasMany(User::class);
    }
    // public function semester() {
    //     return $this->hasMany(Semester::class);
    // }
}
