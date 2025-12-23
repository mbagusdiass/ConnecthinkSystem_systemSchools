<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'nisn',
        'name',
        'parent_id',
        'gender',
        'email',
        'address',
        'classroom_id',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }
}
