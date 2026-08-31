<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signalement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'signalements';

    protected $fillable = [
        'raison',
        'date_signalement',
        'statut',
        'idUtilisateur_emetteur',
        'id_Utilisateur_Admin',
        'id_Offre_De_Stage',
    ];

    protected $casts = [
        'date_signalement' => 'date',
    ];

    public function emetteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUtilisateur_emetteur');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_Utilisateur_Admin');
    }

    public function offreDeStage(): BelongsTo
    {
        return $this->belongsTo(Offredestage::class, 'id_Offre_De_Stage');
    }
}