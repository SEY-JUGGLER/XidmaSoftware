<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services/Index', [
            'services' => Service::actif()->orderBy('ordre_affichage')->get(),
        ]);
    }

    public function show(Service $service): Response
    {
        if (! $service->actif) {
            abort(404);
        }

        return Inertia::render('Services/Show', [
            'service' => $service,
            'realisations' => $service->realisations()->publie()->latest('date_realisation')->get(),
        ]);
    }
}
