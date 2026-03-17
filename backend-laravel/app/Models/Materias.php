<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Materias extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome_materia',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}