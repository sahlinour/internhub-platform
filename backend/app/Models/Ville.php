<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ville extends Model
{
use HasFactory;
protected $fillable = ['nom'];

public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
