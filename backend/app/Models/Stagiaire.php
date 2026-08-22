<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    protected $table = 'stagiaires';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'universite',
        'filiere',
        'niveau',
        'date_naissance',
        'cv_url',
        'linkedin_url',
        'portfolio_url',
        'statut_stage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}