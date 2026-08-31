<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class, 'id_Candidature');
    }

    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(Encadrant::class, 'idUtilisateur_Encadrant', 'user_id');
    }
}