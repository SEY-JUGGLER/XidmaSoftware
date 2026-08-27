<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Temoignage;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'services' => Service::actif()->orderBy('ordre_affichage')->get(),
            'realisations' => Realisation::publie()->latest('date_realisation')->take(3)->get(),
            'temoignages' => Temoignage::actif()->inRandomOrder()->take(3)->get(),
            'articles' => Article::publie()->latest('publie_le')->take(3)->get(),
        ]);
    }
}
