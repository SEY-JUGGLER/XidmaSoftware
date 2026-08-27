<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ConfirmationContact;
use App\Mail\NouveauContact;
use App\Models\Lead;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact', [
            'services' => Service::actif()->orderBy('ordre_affichage')->get(['id', 'titre']),
        ]);
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        if ($request->isHoneypotFilled()) {
            return redirect()->back()->with('success', 'Votre message a bien été envoyé. Nous vous recontacterons rapidement.');
        }

        $lead = Lead::create($request->validated());

        Mail::to(config('mail.from.address'))
            ->queue(new NouveauContact($lead));

        Mail::to($lead->email)
            ->queue(new ConfirmationContact($lead));

        return redirect()
            ->back()
            ->with('success', 'Votre message a bien été envoyé. Nous vous recontacterons rapidement.');
    }
}
