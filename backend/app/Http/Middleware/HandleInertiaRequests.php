<?php

namespace App\Http\Middleware;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $hasStage = false;

        if (Auth::check() && $request->user()->role === 'Stagiaire') {
            $hasStage = Stage::whereHas('candidature', function ($query) {
                $query->where(
                    'idUtilisateur_Stagiaire',
                    Auth::id()
                );
            })->exists();
        }

        return [
            ...parent::share($request),

            'auth' => [
                'user' => $request->user(),
            ],

            'stagiaire' => [
                'has_stage' => $hasStage,
            ],
        ];
    }
}