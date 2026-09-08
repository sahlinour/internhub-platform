<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidature extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'candidatures';

    protected $fillable = [
        'statut',
        'date_postulation',
        'lettre_de_motivation',
        'piece_jointe',
        'cv_url',
        'idUtilisateur_Stagiaire',
        'id_Offre_De_Stage',
    ];

    protected $casts = [
        'date_postulation' => 'date',
    ];

    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'idUtilisateur_Stagiaire', 'user_id');
    }

    public function offreDeStage(): BelongsTo
    {
        return $this->belongsTo(Offredestage::class, 'id_Offre_De_Stage');
    }

    
    public function stage(): HasOne
    {
        return $this->hasOne(Stage::class, 'id_Candidature');
    }
}