<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    protected $table = 'stagiaires';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'universite',
        'filiere',
        'niveau',
        'date_naissance',
        'cv_url',
        'linkedin_url',
        'portfolio_url',
        'statut_stage',
    ];

    /**
     * Get the associated base user profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Offers saved as favorites by the Stagiaire.
     */
    public function favoris()
    {
        return $this->belongsToMany(
            Offredestage::class,
            'favoris',
            'idUtilisateur_Stagiaire',
            'id_Offre_De_Stage',
            'user_id',
            'id'
        )->withTimestamps();
    }

    /**
     * Skills belonging to the Stagiaire via Possede pivot.
     */
    public function competences()
    {
        return $this->belongsToMany(
            Competence::class,
            'possede',
            'idUtilisateur_Stagiaire',
            'id_Competence',
            'user_id',
            'id'
        )->withPivot(['niveau', 'experience', 'date_ajout']);
    }

    /**
     * Applications submitted by the Stagiaire.
     */
    public function candidatures()
    {
        return $this->hasMany(
            Candidature::class,
            'idUtilisateur_Stagiaire',
            'user_id'
        );
    }
}