<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'nip',
        'name',
        'gender',
        'email',
        'expertise',
        'address',
        'classroom_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
