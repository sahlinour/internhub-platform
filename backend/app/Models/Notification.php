<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'titre',
        'message',
        'lu',
        'date_envoi',
        'id_Utilisateur',
    ];

    protected $casts = [
        'lu'         => 'boolean',
        'date_envoi' => 'datetime',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_Utilisateur');
    }
}