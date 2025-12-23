<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'address',
    ];
    public function students()
    {
        return $this->hasOne(Student::class);
    }
}
