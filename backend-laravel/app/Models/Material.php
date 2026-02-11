<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_url',
        'order',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
