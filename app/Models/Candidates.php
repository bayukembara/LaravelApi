<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;
    protected $fillable = ['job_id', 'name', 'email', 'phone', 'year'];
}