<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documents';

    protected $fillable = [
        'nom',
        'version',
        'statut',
        'fichier_url',
        'idUtilisateur_Encadrant',
        'id_Stage',
    ];

    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(Encadrant::class, 'idUtilisateur_Encadrant', 'user_id');//,'ville_id'
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'id_Stage');
    }
}