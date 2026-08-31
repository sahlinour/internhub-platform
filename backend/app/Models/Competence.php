<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'competences';

    protected $fillable = [
        'nom_competence',
    ];

    // Relation Many-to-Many avec Stagiaire via la table pivot "possede"
    public function stagiaires(): BelongsToMany
    {
        return $this->belongsToMany(
            Stagiaire::class,
            'possede',
            'id_Competence',
            'idUtilisateur_Stagiaire'
        )->withPivot('niveau', 'experience', 'date_ajout');
    }
}