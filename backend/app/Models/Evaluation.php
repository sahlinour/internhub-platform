<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evaluations';

    protected $fillable = [
        'type_evaluation',
        'note_technique',
        'note_relationnelle',
        'note_global',
        'remarque_encadrant',
        'date_evaluation',
        'idUtilisateur_Encadrant',
        'id_Stage',
    ];

    protected $casts = [
        'note_technique'     => 'float',
        'note_relationnelle' => 'float',
        'note_global'        => 'float',
        'date_evaluation'    => 'date',
    ];

    public function encadrant(): BelongsTo
    {
        return $this->belongsTo(Encadrant::class, 'idUtilisateur_Encadrant', 'user_id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'id_Stage');
    }
}