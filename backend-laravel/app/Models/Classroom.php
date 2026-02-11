<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'subject',
        'level',
        'status',
        'start_time',
        'end_time',
        'max_students',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_user');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
