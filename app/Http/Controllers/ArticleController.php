<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Blog/Index', [
            'categories' => Article::query()
                ->where('statut', true)
                ->distinct()
                ->orderBy('categorie')
                ->pluck('categorie'),
            'categorie' => $request->string('categorie')->toString(),
            'articles' => Article::publie()
                ->when($request->string('categorie')->toString(), fn ($query, $categorie) => $query->where('categorie', $categorie))
                ->latest('publie_le')
                ->paginate(9),
        ]);
    }

    public function show(Article $article): Response
    {
        if (! $article->statut) {
            abort(404);
        }

        return Inertia::render('Blog/Show', [
            'article' => $article,
            'articles_recents' => Article::publie()
                ->where('id', '!=', $article->id)
                ->latest('publie_le')
                ->take(3)
                ->get(),
        ]);
    }
}
