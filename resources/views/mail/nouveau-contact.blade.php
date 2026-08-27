<x-mail::message>
# Nouveau contact reçu

Un visiteur du site a soumis le formulaire de contact.

### Coordonnées

- **Nom :** {{ $lead->nom }}
- **Email :** {{ $lead->email }}
- **Téléphone :** {{ $lead->telephone ?? 'Non renseigné' }}
- **Entreprise :** {{ $lead->entreprise ?? 'Non renseignée' }}
- **Service intéressé :** {{ $lead->serviceInteresse?->titre ?? 'Non précisé' }}
- **Message :**

@if($lead->message)
> {{ $lead->message }}
@else
Aucun message complémentaire.
@endif

<x-mail::button :url="url('/admin/leads')">
Voir dans l'admin
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>