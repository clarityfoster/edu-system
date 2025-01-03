<?php

namespace App\Models;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    public function semester() {
        return $this->belongsTo(Semester::class);
    }
    public function user() {
        return $this->hasMany(User::class);
    }
}
