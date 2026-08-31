<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tache extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'taches';

    protected $fillable = [
        'titre',
        'description',
        'priorite',
        'date_creation',
        'date_echeance',
        'date_fin_effective',
        'statut',
        'idUtilisateur',
        'id_Stage',
    ];

    protected $casts = [
        'date_creation'      => 'date',
        'date_echeance'      => 'date',
        'date_fin_effective' => 'date',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUtilisateur');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'id_Stage');
    }
}