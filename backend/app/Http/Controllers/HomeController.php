<?php

namespace App\Http\Controllers;

use App\Models\Offredestage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $offres = Offredestage::with([
            'entreprise.user.ville',
        ])
            ->where('statut', 'ouverte')
            ->latest('id')
            ->take(3)
            ->get();

        return Inertia::render('Home', [
            'offres' => $offres,
        ]);
    }
}