<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $table = 'entreprises';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'secteur',
        'adresse',
        'site_web',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function encadrants()
    {
        return $this->hasMany(
            Encadrant::class,
            'entreprise_id',
            'user_id'
        );
    }
}