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
}