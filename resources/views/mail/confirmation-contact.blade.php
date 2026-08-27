<x-mail::message>
# Nous avons bien reçu votre message

Bonjour {{ $lead->nom }},

Merci de votre prise de contact. L'équipe Xidma Software a bien reçu votre message et vous recontactera dans les plus brefs délais.

### Votre demande

- **Email :** {{ $lead->email }}
- **Entreprise :** {{ $lead->entreprise ?? 'Non renseignée' }}
- **Service intéressé :** {{ $lead->serviceInteresse?->titre ?? 'Non précisé' }}

Pour toute urgence, n'hésitez pas à nous joindre par téléphone.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>