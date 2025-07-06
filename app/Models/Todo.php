<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'time', 'date', 'bio', 'is_complete'];
    /** @use HasFactory<\Database\Factories\TodosFactory> */
    use HasFactory;
}
