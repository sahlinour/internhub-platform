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
            ->latest('id')
            ->take(6)
            ->get();

        return Inertia::render('Home', [
            'offres' => $offres,
        ]);
    }
}