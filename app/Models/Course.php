<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'type',
        'status',
        'registration_start', 
        'registration_end', 
        'remaining_slots',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
}
