<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Break_time extends Model
{
    use HasFactory;

    protected $fillable = ['restIn','restOut','total_time'];
}
