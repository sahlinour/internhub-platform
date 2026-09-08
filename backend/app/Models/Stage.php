<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Stage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stages';

    protected $fillable = [
        'sujet',
        'date_debut',
        'date_fin',
        'statut',
        'idUtilisateur_Encadrant',
        'id_Candidature',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    /**
     * Relationship: Stage belongs to a Candidature.
     */
    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'id_Candidature');
    }

    /**
     * Relationship: Stage belongs to an Encadrant (using encadrants.user_id PK).
     */
    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(Encadrant::class, 'idUtilisateur_Encadrant', 'user_id');
    }

    /**
     * Relationship: Stage has many Taches.
     */
    public function taches(): HasMany
    {
        return $this->hasMany(Tache::class, 'id_Stage');
    }

    /**
     * Relationship: Stage has many Documents.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'id_Stage');
    }

    /**
     * Shortcut Relationship: Access Stagiaire through Candidature.
     */
    public function stagiaire(): HasOneThrough
    {
        return $this->hasOneThrough(
            Stagiaire::class,
            Candidature::class,
            'id',                          // Foreign key on candidatures table...
            'user_id',                     // Foreign key on stagiaires table...
            'id_Candidature',              // Local key on stages table...
            'idUtilisateur_Stagiaire'      // Local key on candidatures table...
        );
    }
}