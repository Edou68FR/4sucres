@component('mail::message')
# Bienvenue sur 4sucres

Bienvenue {{ $user->email }} !

Dernière étape avant d'embarquer, tu dois confirmer ton email en cliquant sur le bouton ci-dessous :

@component('mail::button', ['url' => route('auth.verify-email', $token)])
Vérifier mon adresse email
@endcomponent

Merci,<br>
L'équipe 4sucres
@endcomponent