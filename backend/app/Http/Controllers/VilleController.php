<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use Inertia\Inertia;

class VilleController extends Controller
{
    public function index()
{
    $villes = Ville::all();

    return Inertia::render('Villes/Index', [
        'villes' => $villes,
    ]);
}

    public function show($id)
    { ;

        return Inertia::render('Villes/Show', [
            'ville' => Ville::findOrFail($id),
        ]);
    }
}