<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favoris extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'favoris';

    protected $fillable = [
        'idUtilisateur_Stagiaire',
        'id_Offre_De_Stage',
    ];

    public function stagiaire(): BelongsTo
    {
        return $this->belongsTo(Stagiaire::class, 'idUtilisateur_Stagiaire', 'user_id');
    }

    public function offreDeStage(): BelongsTo
    {
        return $this->belongsTo(Offredestage::class, 'id_Offre_De_Stage');
    }
}