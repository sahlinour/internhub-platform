<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nom_complet',
        'email',
        'password',
        'telephone',
        'photo',
        'role',
        'etat',
        'ville_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ville de l'utilisateur
     */
    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id');
    }

    /**
     * Profil stagiaire
     */
    public function stagiaire()
    {
        return $this->hasOne(Stagiaire::class, 'user_id');
    }

    /**
     * Profil encadrant
     */
    public function encadrant()
    {
        return $this->hasOne(Encadrant::class, 'user_id');
    }

    /**
     * Profil entreprise
     */
    public function entreprise()
    {
        return $this->hasOne(Entreprise::class, 'user_id');
    }
}