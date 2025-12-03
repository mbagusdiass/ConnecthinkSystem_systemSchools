<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'nisn',
        'name',
        'gender',
        'email',
        'address',
        'classroom_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
