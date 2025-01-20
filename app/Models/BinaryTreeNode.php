<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinaryTreeNode extends Model
{
    use HasFactory;

        protected $fillable = ['level', 'value'];

}
