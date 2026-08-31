<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Possede extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'possedes';
    
    // Annule la recherche par clé 'id' standard
    public $incrementing = false;
    protected $primaryKey = ['id_Competence', 'idUtilisateur_Stagiaire'];

    protected $fillable = [
        'id_Competence',
        'idUtilisateur_Stagiaire',
        'niveau',
        'experience',
        'date_ajout',
    ];

    protected $casts = [
        'date_ajout' => 'date',
    ];

    public function competence(): BelongsTo
    {
        return $this->belongsTo(Competence::class, 'id_Competence');
    }

    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'idUtilisateur_Stagiaire', 'user_id');
    }
}