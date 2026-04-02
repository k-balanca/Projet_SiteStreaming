<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Autorise l'assignation de masse sur tous les champs
    protected $guarded = [];
    // ou protected $fillable = ['user_id', 'imdb_id'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
