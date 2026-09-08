<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'admins';

   
    protected $primaryKey = 'idUtilisateur';

    
    public $incrementing = false;

    protected $fillable = [
        'idUtilisateur',
    ];

    /**
     * Relationship: Admin belongs to base User/Utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUtilisateur');
    }

    
    public function signalements(): HasMany
    {
        return $this->hasMany(Signalement::class, 'id_Utilisateur_Admin', 'idUtilisateur');
    }
}