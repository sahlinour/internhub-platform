<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offredestage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'offredestages';

    protected $fillable = [
        'titre',
        'description',
        'duree',
        'date_limite',
        'statut',
        'idUtilisateur_Entreprise',
    ];

    protected $casts = [
        'date_limite' => 'date',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class, 'idUtilisateur_Entreprise', 'user_id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'id_Offre_De_Stage');
    }

    public function signalements(): HasMany
    {
        return $this->hasMany(Signalement::class, 'id_Offre_De_Stage');
    }

    public function favorisParStagiaires(): BelongsToMany
    {
        return $this->belongsToMany(
            Stagiaire::class,
            'favoris',
            'id_Offre_De_Stage',
            'idUtilisateur_Stagiaire'
        );
    }
}