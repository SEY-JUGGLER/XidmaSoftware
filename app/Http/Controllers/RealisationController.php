<?php

namespace App\Http\Controllers;

use App\Models\Realisation;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RealisationController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Realisations/Index', [
            'services' => Service::actif()->orderBy('ordre_affichage')->get(['id', 'titre', 'slug']),
            'service_id' => $request->integer('service'),
            'realisations' => Realisation::query()
                ->when($request->integer('service'), fn ($query, $serviceId) => $query->where('service_id', $serviceId))
                ->publie()
                ->latest('date_realisation')
                ->get(),
        ]);
    }

    public function show(Realisation $realisation): Response
    {
        if (! $realisation->publie) {
            abort(404);
        }

        return Inertia::render('Realisations/Show', [
            'realisation' => $realisation->load('service'),
        ]);
    }
}
