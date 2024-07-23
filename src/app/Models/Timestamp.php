<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable = ['punchIn','punchOut'];

    public function break_time()
    {
        return $this->hasMany(Timestamp::class);
    }
}
