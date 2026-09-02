<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encadrant extends Model
{
    protected $table = 'encadrants';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'poste',
        'specialite',
        'departement',
        'entreprise_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(
            Entreprise::class,
            'entreprise_id',
            'user_id'
        );
    }
    public function stages()
    {
        return $this->hasMany(Stage::class, 'idUtilisateur_Encadrant', 'user_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class, 'idUtilisateur_Encadrant', 'user_id');
    }
    public function evaluations(){
        return $this->HasMany(Evaluation::class, 'idUtilisateur_Encadrant', 'user_id');
    }
}