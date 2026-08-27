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
        'idUtilisateur',
        'id_Stage',
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